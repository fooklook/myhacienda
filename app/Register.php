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
        $this->register = new Register();
        $this->register->user_email = $request["user_email"];
        $this->register->user_password = md5($request["user_password"]);
        $this->register->user_token = Myhelper::getRandChar(10);
        $this->register->user_again_token = Myhelper::getRandChar(10);
        if(!$this->register->save()){
            return false;
        }
        //发送验证邮件
        if($this->sendmail($this->register)) {
            return true;
        }else{
            $this->register->status = -1;
            $this->register->save();
            $infor = "邮件发送失败！管理员解决该问题后，会主动联系你。";
            return false;
        }
    }

    /**
     * 再次发送邮件验证请求
     * @param string $again_token 再次发送邮件的token
     */
    public static function again_email($again_token, &$infor){
        $register = Register::where(array("user_again_token"=>$again_token))->first();
        //未找到
        if(is_null($register)){
            $infor = "注册信息未找到，请注册后尝试。";
        }else{
            if($register->status == 1){
                $infor = "邮箱已经验证成功！请返回首页。";
                return false;
            }else{
                if($register->count>=3){
                    $infor = "验证邮件已经发往您的邮箱，请耐心等待。";
                    return false;
                }else{
                    if($register->sendmail($register)){
                        $register->count = $register->count + 1;
                        $register->status = 0;
                        $register->save();
                        $infor = "邮件发送成功！";
                        return true;
                    }else{
                        $infor = "邮件发送失败！管理员解决该问题后，会主动联系你。";
                        $register->status = -1;
                        $register->save();
                        return false;
                    }
                }
            }
        }
    }
    /**
     * 发送验证邮件
     * @param $register
     */
    public function sendmail($register){
        //发送邮件
//        return Mail::send('auth.registeremail', ['register'=>$register], function($message) use($register){
//            $message->to($register->user_email)->subject('邮箱验证-Fooklook');
//        });
        return true;
    }
}
