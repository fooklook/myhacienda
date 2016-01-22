<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleClassify extends Model {

    protected $table = 'article_classify';

    protected $primaryKey = 'article_classify_id';

    public $timestamps = false;

    protected $fillable = array('article_classify_name', 'article_classify_trunk_id', 'created_at');

    public $cache_name = 'article_classify';

    public function cache_json(){
        $all = self::all()->toArray();
        $array = array();
        foreach($all AS $key=>$value){
            $array[$value->article_classify_id] = $value->article_classify_name;
        }
        return json_encode($array);
    }

}
