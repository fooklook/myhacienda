<?php
namespace App\Lib;

use App\Lib\Sync_md;
use App\Lib\Sync_image;
use App\User;

/**
 * Class Sync_github
 * @package App\Lib
 * 接受github信息推送，将更新内容添加到数据库。
 */

class Sync_github{

    //操作用户
    private $user;

    public function __construct(){
        return true;
    }

    /**
     * @param string $json github传来的json数据
     */
    public function perform($json){
        //解析json数据
        $array = json_decode($json);
    }

    /**
     * 通过邮箱地址确认用户
     * @param $email
     */
    private function Verify_user($email){
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


}
