<?php namespace App;
use Illuminate\Database\Eloquent\Model;
class AdminUser extends Model {

    protected $table = 'admin_user';

    protected $primaryKey = 'admin_id';

    public $timestamps = false;

    protected $fillable = array('admin_id','auto_user_id','user_id','user_power','created_at');
}
