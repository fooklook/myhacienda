<?php namespace App\Commands;

use App\Commands\Command;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Illuminate\Support\Facades\Mail;

class SendEmail extends Command implements SelfHandling, ShouldBeQueued {

	use InteractsWithQueue, SerializesModels;

	public $register;
	private $email;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($email)
	{
		$this->email = $email;
		//$this->register = $register;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
		$email = $this->email;
		//发送邮件
		Mail::send('welcome', [], function($message) use ($email){
			$message->to($email)->subject('邮箱验证-Fooklook');
		});
	}

}
