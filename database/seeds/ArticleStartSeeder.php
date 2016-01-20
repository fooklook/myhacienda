<?php
use Illuminate\Database\Seeder;
use \App\ConnType;

class ArticleStartSeeder extends Seeder {
    public function run(){
        /**
         * 初始化文章内容系统
         */
        //文章内容类型
        $array = array('html','md');
        foreach($array as $value) {
            $conntype = new ConnType();
            $conntype->conn_type = $value;
            $conntype->created_time = \Carbon\Carbon::now();
            $conntype->save();
        }
    }
}