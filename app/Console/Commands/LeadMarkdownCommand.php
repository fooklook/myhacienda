<?php namespace App\Console\Commands;

use App\Album;
use App\AlbumImage;
use App\Article;
use App\ArticleClassify;
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
	protected $description = '将markdown文件内容转换成html，并存储到数据库中。';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/** 用户信息 **/
	private $user;
	/** 引用本地链接的文章id数组 **/
	private $wait_article = array();

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire(){
		header("Content-type: text/html; charset=utf-8");
		//管理员登录
		$this->user = $this->login();
		//需要遍历的目录
		$path = 'D:/laravel/laravelnote';
		//从根目录的README文件导入分类，并获取目录与分类之间的对应关系。
		$path_array = $this->classify($path . '/' .'README.md');
		//遍历
		foreach($path_array as $key=>$value){
			echo "开始导入{$value}目录内容\r\n";
			$this->ergodic($key, $path . '/' . $value);
		}
	}

	/** 解析根目录下的README文件，导入主分类信息 **/
	public function classify($Path){
		echo "开始创建分类：\r\n";
		DB::table('article_classify')->truncate();
		$file = fopen($Path, "r") or exit('读取分类文件失败');
		$classify_path = array();
		while(!feof($file)){
			//读取分类名称
			$conn = fgets($file);
			$pattern = '/##(.*)-(.*)/i';
			preg_match($pattern,$conn,$conn_pattern);
			$name = $conn_pattern[1];
			//读取分类描述
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
		echo "导入分类成功！\r\n";
		//返回目录
		return $classify_path;
	}

	/** 遍历目录下的内容 **/
	private function ergodic($article_classify_id, $Path){
		$handle = opendir($Path);
		while(($file = readdir($handle)) !== false){
			if($file == '.' ||  $file == '..' || $file == 'README.md'){
				continue;
			}
			if($file == "images"){
				$this->update_qiniu($Path . '/' . 'images');
				continue;
			}
			//将md文件写入数据库
			$this->md2db($article_classify_id, $Path . '/' . $file);
		}
		closedir($handle);
	}

	/** 上传七牛图片 **/
	private function update_qiniu($Path){
		echo "发现该目录下存在图片，上传到七牛服务器中...\r\n";
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
				//将图片上传到七牛服务器上
				$disk = \Storage::disk('qiniu');
				$qiniu_image_src = $this->qiniu_imgname($file_name);
				//如果图片存在，则跳出。
				if($disk->exists($qiniu_image_src)){
					$exist_num++;
					continue;
				}
				$upload_num++;
				$contents = file_get_contents($file_name);

				if($disk->put($qiniu_image_src, $contents)){
					echo $file_name . "上传成功\r\n";
				}
				//将七牛图片地址写到数据库中
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
		echo "完成上传，共上传{$upload_num}张图片，该目录在线上共{$total_num}张图片\r\n";
	}

	/** 上传到七牛的图片，命名规则 **/
	private function qiniu_imgname($file_name){
		$path_info = pathinfo($file_name);
		$explode = explode('/',$path_info['dirname']);
		//图片所在目录
		$path = $explode[count($explode)-2];
		return 'fk_' . $path . '_' . md5($path_info['basename']) . '.' . $path_info['extension'];
	}

	/** 用户登录 **/
	private function login(){
		do{
			$name = $this->ask("Login username：");
			$password = $this->secret("{$name}'s password：");
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
		//用户信息
		return $user[0];
	}

//	/** 测试 **/
//	public function fire(){
//		$this->md2db('D:/laravel/laravelnote/phpnote/搜索引擎基本原理.md');
//		//$this->md2db('D:/laravel/laravelnote/laravelnote/README.md');
//	}
	/** 将md的内容写入到数据库中 **/
	private function md2db($article_classify_id , $file_name){
		echo "开始导入{$file_name}==========>";
		$file_array = pathinfo($file_name);
		//获取文章标题
		$file = fopen($file_name, "r") or exit('读取分类文件失败');
		$title = fgets($file);
		$title = str_replace('#','',$title);
		fclose($file);
		$file_conn = file_get_contents($file_name);
		//匹配是否包换本地图片
		$pattern = '/\((\.\/images\/.*)\)/isU';
		preg_match_all($pattern,$file_conn,$match);
		if(count($match[1]) > 0) {
			$replace = array();
			foreach ($match[1] as $value) {
				$tmp = explode("/", $value);
				$file_array['dirname'] . '/images/' . $tmp[(count($tmp) - 1)];
				$replace[] = 'http://' . env('QINIU_DOMAINS_DEFAULT') . '/' . $this->qiniu_imgname($file_array['dirname'] . 'images' . $tmp[(count($tmp) - 1)]);
			}
			$file_conn = str_replace($match[1], $replace, $file_conn);
		}

		$article = new Article();
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
		echo "导入成功！\r\n";
	}
}
