<?php
/**
 * Created by PhpStorm.
 * User: administration
 * Date: 2016/2/20
 * Time: 18:15
 */

namespace App\Lib;


use App\Album;
use App\AlbumImage;

class Sync_image extends Sync_file
{
    //用户信息
    private $user;

    public function __construct($user){
        $this->user = $user;
    }

    /**
     * 新增
     * @param string $json 添加的内容
     * @return boolean
     */

    public function added($filename){
        //抓取内容
        $content = new contents_github($filename);
        $disk = \Storage::disk('qiniu');
        $qiniu_image_src = self::qiniu_imgname($filename);
        $disk->put($qiniu_image_src, $content->content);
        //获取图片后缀
        $explode = explode('.',$filename);
        $ext = strtolower(end($explode));
        //写入到相册中
        $album = Album::default_album($this->user);
        $image = new AlbumImage();
        $image->album_id = $album->album_id;
        $image->image_src = 'http://' . env('QINIU_DOMAINS_DEFAULT') . '/' .$qiniu_image_src;
        $image->image_type = $ext;
        $image->created_at = \Carbon\Carbon::now();
        $image->save();
        return true;
    }

    /**
     * 删除
     * @param $json
     * @return boolean
     */
    public function removed($filename){
        return true;
    }

    /**
     * 修改
     * @param $json
     * @return bool
     */
    public function modified($filename){
        //抓取内容
        $content = new contents_github($filename);
        $disk = \Storage::disk('qiniu');
        $qiniu_image_src = self::qiniu_imgname($filename);
        $disk->put($qiniu_image_src, $content->content);
        return true;
    }

    /**
     * 生成七牛图片地址
     * @param $file_name
     * @return string
     */
    public static function qiniu_imgname($file_name){
        $explode = explode('/',$file_name);
        //目录名称
        $path = reset($explode);
        $name = end($explode);
        $ext = explode('.', $file_name);
        $extension = end($ext);
        return env('QINIU_PREFIX') . $path . '_' . md5($name) . '.' . $extension;
    }
}