<?php
/**
 * Created by PhpStorm.
 * User: administration
 * Date: 2016/2/20
 * Time: 18:14
 */

namespace App\Lib;

use App\Lib\Sync_file;

class Sync_md extends Sync_file
{
    public function __construct(){
        //获取远程地址
        $this->api_url();
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