<?php namespace App;
use Illuminate\Database\Eloquent\Model;
use App\User;

class Album extends Model {

    protected $table = 'album';

    protected $primaryKey = 'album_id';

    public $timestamps = true;

    protected $fillable = array('user_id', 'album_name', 'album_describe', 'album_cover');

    /** 默认相册 **/
    public static function default_album(User $user){
        //用户的第一个相册，即为默认相册。
        $album = self::where('user_id', '=', $user->user_id)->get();
        if(count($album)>0){
            $default = $album[0];
        }else{
            $default = self::create_default_album($user);
        }
        return $default;
    }

    /** 创建默认相册 **/
    public static function create_default_album(User $user){
        $album = new self;
        $album->user_id = $user->user_id;
        $album->album_name = "默认相册";
        $album->album_describe = "用户上传图片，默认存储相册。";
        $album->album_cover = "";
        $album->save();
        return $album;
    }

}