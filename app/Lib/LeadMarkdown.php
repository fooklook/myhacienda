<?php
namespace App\Lib;
use App\Album;
use App\AlbumImage;
use App\Article;
use App\ArticleClassify;
use App\RecordMd;
use App\User;
use Illuminate\Support\Facades\DB;

class LeadMarkdown {

    /** 管理员信息 **/
    private $user;
    /** 等待将本地链接转换成数据库链接的文章 **/
    private $wait_article = array();

    /**
     * 初始化项目，传入用户id
     */
    public function __construct($user){
        $this->user = $user;
    }

    /**
     * 遍历目录，生成类别并将项目md内容导入到数据库中
     * @param string $path 需要导入的根目录
     */
    public function leadin($path){
        //读取根目录的README.md文件，创建分类，并获取目录信息。
        echo "reading README\r\n";
        $path_array = $this->classify($path . '/' .'README.md');
        //遍历目录
        foreach($path_array as $key=>$value){
            echo "reading {$value}:\r\n";
            $this->ergodic($key, $path . '/' . $value);
        }
        dd($this->wait_article);
        //记录结果
        $record = RecordMd::where(array('record_type'=>1,'record_status'=>1))->first();
        if(is_null($record)){
            $record_type = 1;
        }else{
            $record_type = 2;
        }
        $write_record = new RecordMd();
        $write_record->user_id = $this->user->user_id;
        $write_record->record_type = $record_type;
        $write_record->record_status = 1;
        $write_record->record_remark = "导入成功！";
        $write_record->created_at = \Carbon\Carbon::now();
        $write_record->save();
    }

    /**
     * 通过README.md文件分析分类信息
     * @param string $Path 目录名称
     * return array 目录结构
     */
    private function classify($Path){
        DB::table('article_classify')->truncate();
        $file = fopen($Path, "r") or exit("can't read $Path");
        $classify_path = array();
        while(!feof($file)){
            //获取分类标题
            $conn = fgets($file);
            $pattern = '/##(.*)-(.*)/i';
            preg_match($pattern,$conn,$conn_pattern);
            $name = $conn_pattern[1];
            $path = $conn_pattern[2];
            //回去分类说明
            $describe = fgets($file);
            $classify = new ArticleClassify();
            $classify->article_classify_name = $name;
            $classify->article_classify_path = $path;
            $classify->article_classify_describe = $describe;
            $classify->article_classify_trunk_id = 1;
            $classify->created_at = \Carbon\Carbon::now();
            $classify->save();
            $classify_path[$classify->article_classify_id] = $conn_pattern[2];
        }
        fclose($file);
        echo "To create classification success\r\n";
        //返回目录结构
        return $classify_path;
    }

    /**
     * 遍历有效目录
     * @param int $article_classify_id 所在分类id
     * @param string $Path              目录地址
     */
    private function ergodic($article_classify_id, $Path){
        $handle = opendir($Path);
        while(($file = readdir($handle)) !== false){
            if($file == '.' ||  $file == '..' || $file == 'README.md'){
                continue;
            }
            //如果遇到图片文件，将文件夹内的图片上传至七牛
            if($file == "images"){
                $this->update_qiniu($Path . '/' . 'images');
                continue;
            }
            //将md文件内容写入到数据库中
            $this->md2db($article_classify_id, $Path . '/' . $file);
        }
        closedir($handle);
    }

    /**
     * 将目录下的图片上传到七牛服务器
     * @param $Path
     */
    private function update_qiniu($Path){
        echo "Find images file，uploading...\r\n";
        $exist_num = 0;
        $upload_num = 0;
        $user = $this->user;
        $handle = opendir($Path);
        if($handle){
            while(($file=readdir($handle)) !== false){
                if($file == "." || $file == ".."){
                    continue;
                }
                $file_name = $Path . '/' .$file;
                $disk = \Storage::disk('qiniu');
                $qiniu_image_src = $this->qiniu_imgname($file_name);
                //判断是否已经上传图片
                if($disk->exists($qiniu_image_src)){
                    $exist_num++;
                    continue;
                }
                $upload_num++;
                $contents = file_get_contents($file_name);

                if($disk->put($qiniu_image_src, $contents)){
                    echo $file_name . "====>upload\r\n";
                }
                //获取图片后缀
                $explode = explode('.',$file_name);
                $ext = strtolower(end($explode));
                //写入到相册中
                $album = Album::default_album($user);
                $image = new AlbumImage();
                $image->album_id = $album->album_id;
                $image->image_src = 'http://' . env('QINIU_DOMAINS_DEFAULT') . '/' .$qiniu_image_src;
                $image->image_type = $ext;
                $image->created_at = \Carbon\Carbon::now();
                $image->save();
            }
            closedir($handle);
        }
        $total_num = $exist_num + $upload_num;
        echo "upload {$upload_num}，all{$total_num}\r\n";
    }

    /**
     * 生成七牛图片地址
     * @param $file_name
     * @return string
     */
    private function qiniu_imgname($file_name){
        $path_info = pathinfo($file_name);
        $explode = explode('/',$path_info['dirname']);
        //目录名称
        $path = $explode[count($explode)-2];
        return env('QINIU_PREFIX') . $path . '_' . md5($path_info['basename']) . '.' . $path_info['extension'];
    }

    /**
     * md文件内容写入到数据库中
     * @param $article_classify_id
     * @param $file_name
     */
    private function md2db($article_classify_id , $file_name){
        echo "{$file_name}==========>";
        $file_array = pathinfo($file_name);
        $file = fopen($file_name, "r") or exit("can'n read $file_name");
        $title = fgets($file);
        $title = str_replace('#','',$title);
        fclose($file);
        $file_conn = file_get_contents($file_name);
        //匹配本地图片地址
        $pattern = '/\((\.\/images\/.*)\)/isU';
        preg_match_all($pattern,$file_conn,$match);
        if(count($match[1]) > 0) {
            $replace = array();
            foreach ($match[1] as $value) {
                $tmp = explode("/", $value);
                $replace[] = 'http://' . env('QINIU_DOMAINS_DEFAULT') . '/' . $this->qiniu_imgname($file_array['dirname'] . 'images' . $tmp[(count($tmp) - 1)]);
            }
            $file_conn = str_replace($match[1], $replace, $file_conn);
        }

        $article = Article::where('article_title','=',$title)->first();
        if(is_null($article)){
            $article = new Article();
        }
        $article->conn_type_id = 2;
        $article->user_id = 1;
        $article->article_classify_id = $article_classify_id;
        $article->article_title = $title;
        $article->article_digest = "";
        $article->article_cover = "";
        $article->article_content = $file_conn;
        $article->article_from = "fooklook";
        $article->article_status = 1;
        $article->created_at = filectime($file_name);
        $article->updated_at = filemtime($file_name);
        $article->save();
        //匹配内容中的本地文章链接
        $pattern = '/\((\.\/)?([^\/]*)\.md\)/is';
        preg_match_all($pattern,$file_conn,$match);
//		dd($match);
        if(count($match[0])>0){
            $this->wait_article[] = $article->article_id;
        }
        echo "Write to successful\r\n";
    }

    /**
     * github上发生push，对内容进行同步。
     * @param string $json github返回的内容
     */
    public function action_push($json){

    }
    /**
     * md文件内容写入到数据库中
     * @param $article_classify_id
     * @param $file_name
     */
    private function push2db($article_classify_id , $file_name){
        $file_array = pathinfo($file_name);
        $file = fopen($file_name, "r") or exit("can'n read $file_name");
        $title = fgets($file);
        $title = str_replace('#','',$title);
        fclose($file);
        $file_conn = file_get_contents($file_name);
        //匹配本地图片地址
        $pattern = '/\((\.\/images\/.*)\)/isU';
        preg_match_all($pattern,$file_conn,$match);
        if(count($match[1]) > 0) {
            $replace = array();
            foreach ($match[1] as $value) {
                $tmp = explode("/", $value);
                $replace[] = 'http://' . env('QINIU_DOMAINS_DEFAULT') . '/' . $this->qiniu_imgname($file_array['dirname'] . 'images' . $tmp[(count($tmp) - 1)]);
            }
            $file_conn = str_replace($match[1], $replace, $file_conn);
        }

        $article = Article::where('article_title','=',$title)->first();
        if(is_null($article)){
            $article = new Article();
        }
        $article->conn_type_id = 2;
        $article->user_id = 1;
        $article->article_classify_id = $article_classify_id;
        $article->article_title = $title;
        $article->article_digest = "";
        $article->article_cover = "";
        $article->article_content = $file_conn;
        $article->article_from = "fooklook";
        $article->article_status = 1;
        $article->created_at = filectime($file_name);
        $article->updated_at = filemtime($file_name);
        $article->save();
        //匹配内容中的本地文章链接
        $pattern = '/\((\.\/)?([^\/]*)\.md\)/is';
        preg_match_all($pattern,$file_conn,$match);
//		dd($match);
        if(count($match[0])>0){
            $this->wait_article[] = $article->article_id;
        }
    }
}