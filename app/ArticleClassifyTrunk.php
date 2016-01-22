<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleClassifyTrunk extends Model {

    protected $table = 'article_classify_trunk';

    protected $primaryKey = 'article_classify_trunk_id';

    public $timestamps = false;

    protected $fillable = array('article_classify_trunk_name','article', 'created_at');

}
