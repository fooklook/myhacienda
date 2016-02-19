<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Hook extends Model {

    protected $table = "hooks";

    /**
     * 解析API github中获取文件内容，并更新到数据库中。
     * @param string $url 获取地址
     */
    public static function parse_content($url){
        
    }

}
