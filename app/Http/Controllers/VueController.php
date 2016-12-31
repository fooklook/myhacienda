<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Article;
use App\ArticleClassify;

use Illuminate\Http\Request;

class VueController extends Controller {
	//添加可跨域访问的中间件
	public function __construct()
    {
        $this->middleware('alloworigin');
	}

	/**
	 * 首页接口数据
	 *
	 * @return Response
	 */
	public function index()
	{
		//返回文章分类信息
		$classifys = ArticleClassify::all();
		foreach($classifys as $key=>$classify){
			$classifys[$key]->url = url('vue/'.$classify->article_classify_id);
		}
		return response()->json($classifys);
	}

	/**
	 * 文章列表页
	 *
	 * @return Response
	 */
	public function listpage($classify,Request $request)
	{
		$pagenum = 20;
		if(is_null($request->page)){
			$page = 0;
		}else{
			$page = $request->page;
		}
		$start = $page * $pagenum;
		if($classify) {
			$classifys = ArticleClassify::all();
			foreach($classifys as $key=>$classify_value){
				$classifys[$key]->url = url('vue/'.$classify_value->article_classify_id);
			}
			$count = Article::where('article_classify_id', $classify->article_classify_id)->count();
			//取消分页处理
			//$articles = Article::where('article_classify_id', $classify->article_classify_id)->skip($start)->take($pagenum)->get();
			$articles = Article::where('article_classify_id', $classify->article_classify_id)->get();
			foreach($articles as $key=>$article){
				$articles[$key]->url = url("vue/{$classify->article_classify_path}/{$article->article_title}");
			}
			$array = array(
				"classifys" => $classifys,
				"articles" => $articles,
				"classify" => $classify,
				"count" => $count
			);
			return response()->json($array);
		}else{
			$array = array(
				"status" => 404,
				"data" => "NOT FIND"
			);
			$content = json_encode($array);
		    $status = 404;
		    $value = 'application/json';
		    return response($content,$status)->header('Content-Type',$value);
		}

	}

	/**
	 * 文章详情页
	 *
	 * @return Response
	 */
	public function detailpage($classify,$article)
	{
		if($classify || $article){
			$classifys = ArticleClassify::all();
			$array = array(
				"classifys" => $classifys,
				"article" => $article,
				"classify" => $classify
			);
			return response()->json($array);
		}else{
			$array = array(
				"status" => 404,
				"data" => "NOT FIND"
			);
			$content = json_encode($array);
		    $status = 404;
		    $value = 'application/json';
		    return response($content,$status)->header('Content-Type',$value);
		}
	}

}
