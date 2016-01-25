<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class RecordMd extends Model {

    protected $table = 'record_md';

    protected $primaryKey = 'record_md_id';

    public $timestamps = false;

    protected $fillable = array('user_id','record_type','record_status','record_remark','created_at');

}
