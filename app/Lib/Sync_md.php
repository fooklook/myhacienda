<?php
namespace App\Lib;

use App\Article;

class Sync_md extends Sync_file
{
    //用户信息
    private $user;

    public function __construct($user){
        $this->user = $user;
    }

    /**
     * 新增
     * @param string $json 添加的内容
     * @return boolean
     */

    public function added($filename){
        //抓取内容
        $content = new contents_github($filename);
        //根据目录获取分类和标题信息
        $classify = $this->path_parse($filename);

        $md = new Article();
        $md->article_classify_id = $classify['classify_id'];
        $md->conn_type_id = 2;
        $md->user_id = $this->user->user_id;
        $md->article_title = $classify['title'];
        $md->article_content = $this->image_url($content->content,$filename);
        $md->article_from = "fooklook";
        $md->created_at = \Carbon\Carbon::now();
        $md->updated_at = \Carbon\Carbon::now();
        $md->save();
        return true;
    }

    /**
     * 删除
     * @param $json
     * @return boolean
     */
    public function removed($filename){
        //根据目录获取分类和标题信息
        $classify = $this->path_parse($filename);
        $title = str_replace('#', '',$classify['title']);
        $md = Article::where('article_title',$title)->first();
        if(!is_null($md)) {
            $md->delete();
        }
        return true;
    }

    /**
     * 修改
     * @param $json
     * @return bool
     */
    public function modified($filename){
        //抓取内容
        $content = new contents_github($filename);
        //根据目录获取分类和标题信息
        $classify = $this->path_parse($filename);
        $md = Article::where('article_title',$classify['title'])->first();
        $md->article_content = $this->image_url($content->content,$filename);
        $md->updated_at = \Carbon\Carbon::now();
        $md->update();
        return true;
    }

    public function image_url($file_conn,$filename){
        $file_tmp = explode('/', $filename);
        $path = reset($file_tmp);
        //匹配本地图片地址
        $pattern = '/\((\.\/images\/.*)\)/isU';
        preg_match_all($pattern, $file_conn, $match);
        if(count($match[1]) > 0) {
            $replace = array();
            foreach ($match[1] as $value) {
                $replace[] = 'http://' . env('QINIU_DOMAINS_DEFAULT') . '/' . Sync_image::qiniu_imgname($path .'/'. $value);
            }
            $file_conn = str_replace($match[1], $replace, $file_conn);
        }
        return $file_conn;
    }
}