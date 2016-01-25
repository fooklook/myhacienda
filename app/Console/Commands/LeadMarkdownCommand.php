<?php namespace App\Console\Commands;

use App\Album;
use App\AlbumImage;
use App\Article;
use App\ArticleClassify;
use App\RecordMd;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class LeadMarkdownCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'lead:markdown';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'markdown written to the database';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/** 管理员信息 **/
	private $user;
	/** 等待将本地链接转换成数据库链接的文章 **/
	private $wait_article = array();

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire(){
		header("Content-type: text/html; charset=utf-8");
		//用户登录
		$this->user = $this->login();
		//遍历的文件目录
		$path = 'D:/laravel/laravelnote';
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

	/** 通过README.md文件分析分类信息 **/
	public function classify($Path){
		DB::table('article_classify')->truncate();
		$file = fopen($Path, "r") or exit("can't read $Path");
		$classify_path = array();
		while(!feof($file)){
			//获取分类标题
			$conn = fgets($file);
			$pattern = '/##(.*)-(.*)/i';
			preg_match($pattern,$conn,$conn_pattern);
			$name = $conn_pattern[1];
			//回去分类说明
			$describe = fgets($file);
			$classify = new ArticleClassify();
			$classify->article_classify_name = $name;
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

	/** 遍历目录 **/
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

	/** 将目录下的图片上传到服务器 **/
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
				//写入到相册中
				$album = Album::default_album($user);
				$image = new AlbumImage();
				$image->album_id = $album->album_id;
				$image->image_src = 'http://' . env('QINIU_DOMAINS_DEFAULT') . '/' .$qiniu_image_src;
				$image->image_type = pathinfo($file_name)['extension'];
				$image->created_at = \Carbon\Carbon::now();
				$image->save();
			}
			closedir($handle);
		}
		$total_num = $exist_num + $upload_num;
		echo "upload {$upload_num}，all{$total_num}\r\n";
	}

	/** 生成七牛图片名称 **/
	private function qiniu_imgname($file_name){
		$path_info = pathinfo($file_name);
		$explode = explode('/',$path_info['dirname']);
		//目录名称
		$path = $explode[count($explode)-2];
		return 'fk_' . $path . '_' . md5($path_info['basename']) . '.' . $path_info['extension'];
	}

	/** 用户登录 **/
	private function login(){
		do{
			$name = $this->ask("Login username:");
			$password = $this->secret("{$name}'s password:");
			$user = User::with('adminuser')->where('user_name','=',$name)->get();
			if(count($user)==0 || $user[0]->user_password != md5($password)){
				echo "Permission denied, please try again.\r\n";
			}else {
				if ($user[0]->adminuser->user_power == 7) {
					break;
				} else {
					echo "Not enough permissions.";
				}
			}
		}while(true);
		return $user[0];
	}

	/** md文件入数据库 **/
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
}
