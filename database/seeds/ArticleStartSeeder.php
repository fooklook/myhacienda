<?php
use Illuminate\Database\Seeder;
use \App\ConnType;
use \App\ArticleClassifyTrunk;

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
            $conntype->created_at = \Carbon\Carbon::now();
            $conntype->save();
        }
        //主分类内容
        $array = array('博客', '晒年货');
        foreach($array as $value){
            $article_classify_trunk = new ArticleClassifyTrunk();
            $article_classify_trunk->article_classify_trunk_name = $value;
            $article_classify_trunk->created_at = \Carbon\Carbon::now();
            $article_classify_trunk->save();
        }
    }
}