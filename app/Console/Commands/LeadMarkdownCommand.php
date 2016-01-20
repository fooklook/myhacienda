<?php namespace App\Console\Commands;

use App\Article;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
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

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		header("content-type:text/html;charset=utf-8");
		//-----用户登录-----
//		do{
//			$name = $this->ask("Login username：");
//			$password = $this->secret("{$name}'s password：");
//			$user = User::with('adminuser')->where('user_name','=',$name)->get();
//			if($user[0]->user_password == md5($password)){
//				if($user[0]->adminuser->user_power == 7){
//					break;
//				}else{
//					echo "Not enough permissions.";
//				}
//			}else{
//				echo "Permission denied, please try again.\r\n";
//			}
//		}while(true);
//
//		//------用户登录结束------
//		//用户信息
//		$user = $user[0];
		$Path = "D:/laravel/laravelnote/README.md";
//		if(!is_dir($Path)){
//			echo '导入失败，文件目录不存在';
//			exit();
//		}
		$file_array = pathinfo($Path);
		//var_dump($file_array);exit;
		$file_conn = file_get_contents($Path);
		$article = new Article();
		$article->conn_type_id = 2;
		$article->user_id = 1;
		$article->article_title = $file_array['filename'];
		$article->article_digest = "";
		$article->article_cover = "";
		$article->article_content = $file_conn;
		$article->article_from = "fooklook";
		$article->article_status = 1;
		$article->save();
	}

}
