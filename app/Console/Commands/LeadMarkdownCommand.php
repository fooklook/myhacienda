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
	protected $description = '��markdown�ļ�����ת����html�����洢�����ݿ��С�';

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
		//-----�û���¼-----
//		do{
//			$name = $this->ask("Login username��");
//			$password = $this->secret("{$name}'s password��");
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
//		//------�û���¼����------
//		//�û���Ϣ
//		$user = $user[0];
		$Path = "D:/laravel/laravelnote/README.md";
//		if(!is_dir($Path)){
//			echo '����ʧ�ܣ��ļ�Ŀ¼������';
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
