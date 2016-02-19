<?php namespace App\Console\Commands;


use App\Lib\LeadMarkdown;
use App\User;
use Illuminate\Console\Command;
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

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire(){
		header("Content-type: text/html; charset=utf-8");
		//用户登录
		$user = $this->login();
		//初始化项目
		$lead = new LeadMarkdown($user);
		//遍历的文件目录
		$path = 'D:/laravel/laravelnote';
		$lead->leadin($path);
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
}
