<?php namespace App;
use Illuminate\Database\Eloquent\Model;
class AdminUser extends Model {
    protected $table = 'admin_user';
    protected $primaryKey = 'book_id';
    protected $fillable = array(
        'book_id',
        'book_name',
        'book_auther',
        'book_press',
        'book_num',
        'book_res',
    );
}
