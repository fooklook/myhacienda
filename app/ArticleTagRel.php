<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleTagRel extends Model {

    protected $table = 'article_tag_rel';

    protected $primaryKey = 'article_tag_rel_id';

    public $timestamps = false;

    protected $fillable = array('article_id', 'article_tag_id', 'created_at');

}
