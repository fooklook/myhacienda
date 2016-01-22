<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Cache extends Model {

    protected $table = 'cache';

    public $timestamps = true;

    protected $primaryKey = 'cache_id';

    protected $fillable = ['cache_name','cache_json'];

    public static function  GetCache(Model $model){
        $result = self::where('cache_name', '=', $model->cache_name)->get();
        //�����»���
        if(count($result)==0){
            $cache = new Cache();
            $cache->cache_name = $model->cache_name;
            $cache->cache_json = $model->cache_json();
            $cache->save();
            return $cache->cache_json;
        }else {
            //��ȡ����
            if ($result[0]->cache_json == '') {
                $result[0]->cache_json = $model->cache_json();
                $result[0]->updated_at = \Carbon\Carbon::now();
                $result[0]->update();
            }
            //返回数据
            return $result[0]->cache_json;
        }
    }
}
