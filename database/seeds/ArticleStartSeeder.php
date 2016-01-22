<?php
use Illuminate\Database\Seeder;
use \App\ConnType;
use \App\ArticleClassifyTrunk;

class ArticleStartSeeder extends Seeder {
    public function run(){
        /**
         * ��ʼ����������ϵͳ
         */
        //������������
        $array = array('html','md');
        foreach($array as $value) {
            $conntype = new ConnType();
            $conntype->conn_type = $value;
            $conntype->created_at = \Carbon\Carbon::now();
            $conntype->save();
        }
        //����������
        $array = array('����', 'ɹ���');
        foreach($array as $value){
            $article_classify_trunk = new ArticleClassifyTrunk();
            $article_classify_trunk->article_classify_trunk_name = $value;
            $article_classify_trunk->created_at = \Carbon\Carbon::now();
            $article_classify_trunk->save();
        }
    }
}