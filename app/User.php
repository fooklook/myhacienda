<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	protected $table = 'user';

	protected $primaryKey = 'user_id';

	protected $fillable = ['user_avatars', 'user_name', 'user_nickname', 'login_ip', 'user_email', 'user_password'];

	protected $hidden = ['password', 'remember_token'];

	public $timestamps = true;

	/** 与adminuser关联 **/
	public function adminuser(){
		return $this->hasOne('App\AdminUser','user_id','user_id');
	}

}
