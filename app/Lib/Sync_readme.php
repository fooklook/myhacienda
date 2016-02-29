<?php
/**
 * Created by PhpStorm.
 * User: administration
 * Date: 2016/2/29
 * Time: 17:49
 */

namespace App\Lib;


use App\ArticleClassify;

class Sync_readme extends Sync_file
{
    /**
     * 修改
     * @param $json
     * @return bool
     */
    public function modified($filename){
        //抓取内容
        $content = new contents_github($filename);
        var_dump($content);
        //分解内容
        $explode_contents = explode("\n", $content->content);
        do{
            $pattern = '/##(.*)-(.*)/i';
            $title_string = current($explode_contents);
            preg_match($pattern,$title_string,$conn_pattern);
            $name = $conn_pattern[1];
            $path = $conn_pattern[2];
            $describe = next($explode_contents);
            $Classify = ArticleClassify::where('article_classify_path',$path)->first();
            if(is_null($Classify)){
                $Classify = new ArticleClassify();
            }
            $Classify->article_classify_name = $name;
            $Classify->article_classify_path = $path;
            $Classify->article_classify_describe = $describe;
            $Classify->article_classify_trunk_id = 1;
            $Classify->created_at = \Carbon\Carbon::now();
            $Classify->save();
        }while(next($explode_contents));
        return true;
    }
}