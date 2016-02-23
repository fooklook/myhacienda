<?php
namespace App\Lib;

class Sync_file
{
    //远程仓库api地址
    private $api_url;

    //错误信息
    private $error;

    //处理类及对应后缀名
    private $extend = array(
        "Sync_image"=>array("jpg","png","ico","gif","jpeg","gif"),
        "Sync_md"=>array("md")
    );

    /**
     * 初始化项目
     * @param string $filename 文件地址
     * @param User $user        用户信息
     */

    public function __construct($filename, $user){
        //验证配置信息
        if(is_null(env('GITHUB_USERNAME')) || is_null(env('GITHUB_REPOSITORY')) || is_null(env('GITHUB_SECRET'))){
            $this->error = "请在.env文件中，填写github相关信息。";
            return false;
        }
        //根据文件名称，判断文件类型。
        //----获取文件后缀名
        $extend = end(explode('.',$filename));
        foreach($this->extend AS $type=>$extends){
            if(in_array($extend, $extends)){
                $sync = new $type($user);
                return $sync;
            }
        }
    }

    /**
     * 初始化拼接链接
     */
    protected function api_url(){
        $this->api_url = "https://api.github.com/repos/" . env('GITHUB_USERNAME') . "/" . env('GITHUB_REPOSITORY') . "/contents/";
    }

    /**
     * 新增
     * @param string $json 添加的内容
     * @return boolean
     */

    private function added($json){
        return true;
    }

    /**
     * 删除
     * @param $json
     * @return boolean
     */
    private function removed($json){
        return true;
    }

    /**
     * 修改
     * @param $json
     * @return bool
     */
    private function modified($json){
        return true;
    }
}