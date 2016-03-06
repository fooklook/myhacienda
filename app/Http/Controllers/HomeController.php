<?php namespace App\Http\Controllers;

use App\Album;
use App\AlbumImage;
use App\ArticleClassify;
use App\User;

class HomeController extends Controller {

	/** ÍøÕ¾Ê×Ò³ **/
	public function index()
	{
		$classifys = ArticleClassify::all();
		return view('home/index',array('classifys'=>$classifys));
	}
}
