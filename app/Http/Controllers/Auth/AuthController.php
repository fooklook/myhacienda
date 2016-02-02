<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Lib\Apidata;
use App\Register;
use Illuminate\Contracts\Auth\Guard;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	*/
	use RegisterController;
	use LoginController;
	use Apidata;

	//错误信息
	protected $error;
	protected $remind;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Register $register)
	{
		$this->auth = $auth;
		$this->register = $register;
		$this->middleware('guest', ['except' => 'getLogout']);
	}

	/**
	 * 生成验证码图片
	 */
	public function getAuthcode(){
		$builder = new CaptchaBuilder();
		//可以设置图片宽高及字体
		$builder->build($width = 100, $height = 35, $font = null);
		//获取验证码的内容
		$phrase = $builder->getPhrase();

		//把内容存入session
		Session::flash('authcode', $phrase);
		//生成图片
		header('Content-Type: image/jpg');
		$builder->output();
	}

}
