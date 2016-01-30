<?php namespace App\Http\Controllers\Auth;

use App\Commands\SendEmail;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

trait RegisterController {

	protected $register;

	public function getRegister()
	{
		return view('auth.login1');
	}

	/**
	 * 提交注册
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function postRegister(Request $request)
	{
		//检查验证码
		if(Session::get('authcode') != $request->input('authcode')){
			//邮箱已经被注册，返回注册页面。
			return view('auth.login1',$request->only('user_email','user_password'))
				->withErrors(array(
					array('register'=>'验证码错误')
				));
		}
		//检查邮箱地址格式
		if($request->input('user_mail')){
			//邮箱已经被注册，返回注册页面。
			return view('auth.login1',$request->only('user_email','user_password'))
				->withErrors(array(
					array('register'=>'验证码错误')
				));
		}
		$infor = "";
		if($this->register->run_register($request->only('user_email', 'user_password'),$infor)){
			//进入跳转页面
			return view('auth.valemail',array('register'=>$this->register->register));
		}else{
			//邮箱已经被注册，返回注册页面。
			return view('auth.remind',array('pattern'=>2))
				->withErrors([
					'register_error' => $infor,
				]);
		}
	}

	/**
	 * 验证邮箱地址
	 */
	public function getValidationemail(){

	}

	/**
	 * 再次发送邮箱验证
	 */
	public function getAgainemail(){
		Bus::dispatch(new SendEmail());

	}
	/**
	 * 提示页面
	 *
	 */
	public function getRemind(){

	}



}
