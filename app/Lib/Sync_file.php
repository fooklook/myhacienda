<?php
namespace App\Lib;

use App\ArticleClassify;

class Sync_file
{
    //远程仓库api地址
    private $api_url;

    //错误信息
    private $error;

    //处理类及对应后缀名
    public static $extend = array(
        "Sync_image"=>array("jpg","png","ico","gif","jpeg","gif"),
        "Sync_md"=>array("md")
    );

    /**
     * 返回文件对象
     * @param string $filename 文件地址
     * @param User $user        用户信息
     * @return object
     */

    public static function instantiate($filename, $user){
        //判断是否为README.md文件-->特殊处理
        if($filename == "README.md"){
            $Sync_readme = new Sync_readme($user);
            return $Sync_readme;
        }
        //根据文件名称，判断文件类型。
        //----获取文件后缀名
        $explode = explode('.',$filename);
        $extend = end($explode);
        foreach(self::$extend AS $type=>$extends){
            if(in_array(strtolower($extend), $extends)){
                $type = __NAMESPACE__ . "\\" . $type;
                $sync = new $type($user);
                return $sync;
            }
        }
        return null;        //不符合同步的内容
    }

    /**
     * 根据目录地址获取分类信息和标题
     * @param string $path 目录地址
     * @return array
     */
    public function path_parse($path){
        $array = array();
        $explode = explode('/',$path);
        //分类名称
        $array['classify'] = reset($explode);
        //分类id
        $classify = ArticleClassify::where('article_classify_path',$array['classify'])->first();
        $array['classify_id'] = $classify->article_classify_id;
        $array['title'] = str_replace('.md','',strtolower(end($explode)));
        return $array;
    }

    /**
     * 新增
     * @param string $json 添加的内容
     * @return boolean
     */

    public function added($json){
        return true;
    }

    /**
     * 删除
     * @param $json
     * @return boolean
     */
    public function removed($json){
        return true;
    }

    /**
     * 修改
     * @param $json
     * @return bool
     */
    public function modified($json){
        return true;
    }
}