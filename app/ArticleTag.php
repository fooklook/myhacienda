<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleTag extends Model {

    protected $table = 'article_tag';

    protected $primaryKey = 'article_tag_id';

    public $timestamps = false;

    protected $fillable = array('article_tag_name', 'created_at');

}
