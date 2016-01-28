<?php namespace App\Http\Controllers\Auth;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
		$infor = "";
		if($this->register->run_register($request->only('user_email', 'user_password'),$infor)){
			//进入跳转页面
			return view('auto.remind',array('register'=>$this->register->register));
		}else{
			//邮箱已经被注册，返回注册页面。
			return redirect('auto.login1')
				->withInput($request->only('user_email', 'user_password'))
				->withInput(array('page'=>'register'))
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
	 * 发送邮件测试
	 */
	public function getSeedmail(){

	}

}
