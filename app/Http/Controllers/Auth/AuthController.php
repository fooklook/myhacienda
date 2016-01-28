<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Register;
use Illuminate\Contracts\Auth\Guard;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	*/
	use RegisterController;
	use LoginController;

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

}
