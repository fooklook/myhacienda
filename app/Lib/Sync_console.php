<?php
namespace App\Lib;

use App\Lib\Sync_md;
use App\Lib\Sync_image;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

/**
 * Class Sync_github
 * @package App\Lib
 * 接受github信息推送，将更新内容添加到数据库。
 */

class Sync_console
{
    //操作的用户信息
    private $user;

    //body内容
    private $commits;

    //合法性
    private $valid = true;

    //错误信息
    public $error;

    /**
     * 初始化
     */
    public function __construct(Request $request){
        //初始化验证Secret合法性。
        if(!$this->VerifySignature($request->header('X-Hub-Signature'))){
            $this->valid = false;
            $this->error = "Secret错误";
            return false;
        }
        $body = Input::all();
        $this->commits = $body["commits"];
        $this->api_url();
        return true;
    }

    /**
     * 验证Secret合法性。
     * @param string $Signature 署名 eg: sha1=5801696dc51e716cba6683247fa39faf5e32b208
     * @return boolean
     */

    private function VerifySignature($Signature){
        $explode = explode('=',$Signature);
        $method = $explode[0];
        $result = $explode[1];
        $secret = env('GITHUB_SECRET');
        if($result == $method($secret)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 验证用户信息，判断提交的合法性。
     */

    private function VerifyUser($email){
        $user = User::where('user_email',$email)->frist();
        if(is_null($user)){
            //未找到用户
            return false;
        }else {
            //找到用户
            $this->user = $user;
            return true;
        }
    }

    /**
     * action
     * @return boolean
     */

    public function action(){
        //合法性
        if(!$this->valid){
            return false;
        }
        foreach($this->commits as $commit) {
            //验证用户信息
            if (!$this->VerifyUser($commit["author"]["email"])) {
                $this->valid = false;
                $this->error = "用户不存在";
                return false;
            }

            //新增文章
            foreach ($commit["added"] AS $addad){

            }
        }
    }
}
