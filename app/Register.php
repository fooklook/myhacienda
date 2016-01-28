<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Lib\Myhelper;
use Illuminate\Http\Request;

class Register extends Model {

    protected $table = 'register';

    protected $primaryKey = 'reigster_id';

    protected $fillable = ['user_email', 'user_phone', 'user_password', 'user_token', 'count', 'status'];

    public $timestamps = true;

    public $register;

    /**
     * 验证注册信息，并保存注册信息。
     */
    public function run_register($request, &$infor){
        //判断邮箱是否已经注册
        $user = User::where('user_email', $request["user_email"])->first();
        if(!is_null($user)){
            $infor = '邮箱已经注册';
            return false;
        }
        //删除可能的以前注册信息
        $register = Register::where('user_email', $request["user_email"])->delete();
        $register = new Register();
        $register->user_email = $request["user_email"];
        $register->user_password = md5($request["user_password"]);
        $register->user_token = Myhelper::getRandChar(10);
        $register->user_again_token = Myhelper::getRandChar(10);
        if(!$register->save()){
            return false;
        }
        $this->register = $register;
        //发送邮件
        Mail::send('emails.registeremail', ['register'=>$register], function($message) use($register){
            $message->to($register->user_email)->subject('邮箱验证-Fooklook');
        });
        return true;
    }

    /**
     * 再次发送邮箱验证
     */
    public function again_verify($email){

    }




}
