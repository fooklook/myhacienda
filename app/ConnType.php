<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ConnType extends Model {

    protected $table = 'conn_type';

    public $timestamps = false;

    protected $primaryKey = 'conn_type_id';

    protected $fillable = ['conn_type', 'created_at'];
}
