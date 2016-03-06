<?php
namespace App\Lib;

use App\Commands\SyncFile;
use App\Lib\Sync_file;
use App\Lib\Sync_md;
use App\Lib\Sync_image;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Queue;

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
    public function __construct($request){
        //验证配置信息
        if(is_null(env('GITHUB_USERNAME')) || is_null(env('GITHUB_REPOSITORY')) || is_null(env('GITHUB_SECRET'))){
            dd("请在.env文件中，填写github相关信息。");
        }
        //初始化验证Secret合法性。
//        if(!$this->VerifySignature($request->header('X-Hub-Signature'))){
//            dd("Secret错误");
//            return false;
//        }
        $body = Input::all();
        $this->commits = $body["commits"];
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
        $user = User::where('user_email',$email)->first();
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
                dd("用户不存在");
                return false;
            }
            //新增
            foreach ($commit["added"] AS $addad){
                $sync_file = Sync_file::instantiate($addad,$this->user);
                //$sync_file->added($addad);
                $action = 'added';
                Queue::push(new SyncFile($action,$sync_file,$addad));
            }
            //删除
            foreach ($commit["removed"] AS $removed){
                $sync_file = Sync_file::instantiate($removed,$this->user);
                //$sync_file->removed($removed);
                $action = 'removed';
                Queue::push(new SyncFile($action,$sync_file,$addad));
            }
            //修改
            foreach ($commit["modified"] AS $modified){
                $sync_file = Sync_file::instantiate($modified,$this->user);
                $sync_file->modified($modified);
                $action = 'modified';
                Queue::push(new SyncFile($action,$sync_file,$addad));
            }
        }
    }
}
