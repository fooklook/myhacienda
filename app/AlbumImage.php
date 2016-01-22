<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class AlbumImage extends Model {

    protected $table = 'album_image';

    protected $primaryKey = 'album_image_id';

    public $timestamps = false;

    protected $fillable = array('album_id','image_src','image_type' ,'image_alt' ,'created_at');

}
