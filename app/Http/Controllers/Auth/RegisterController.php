<?php namespace App\Http\Controllers\Auth;

use App\Commands\SendEmail;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Register;
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
		//检查邮箱地址格式
		$pattern = "/^[_.0-9a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,3}$/";
		if(!preg_match($pattern,$request->input("user_email"))){
			return view('auth.login1',$request->only('user_email', 'user_password'))
				->withErrors( array(
					array('register'=>'请输入正确的邮箱地址！')
					)
				);
		}
		//验证密码格式
		if(strlen($request->input("user_password"))<6 || strlen($request->input("user_password"))>18){
			return view('auth.login1',$request->only('user_email', 'user_password'))
				->withErrors( array(
						array('register'=>'请输入6-18位密码!')
					)
				);
		}
		//检查验证码
		if(Session::get('authcode') != $request->input('authcode')){
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
	public function postAgainemail(Request $request){
		if(Register::again_email($request->only('user_again_token'),$infor)){
			$this->data['status'] = 1;
			$this->data['msg'] = $infor;
			echo json_encode($this->data);
			return true;
		}else{

		}

	}
	/**
	 * 提示页面
	 *
	 */
	public function getRemind(){

	}



}
