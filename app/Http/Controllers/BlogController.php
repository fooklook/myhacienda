<?php namespace App\Http\Controllers;

use App\Article;
use App\ArticleClassify;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class BlogController extends Controller {

	/** 博客列表页   **/
	public function listpage($classify){
		$classifys = ArticleClassify::all();
		$articles = Article::where('article_classify_id', $classify->article_classify_id)->paginate(15);
		return view('blog.list', array('classifys'=>$classifys, 'classify'=>$classify, 'articles'=>$articles));

	}

	/** 博客详细页 **/
	public function detailpage($classify,$name){
		if($classify || $name){
			var_dump($name);
		}
	}
}
