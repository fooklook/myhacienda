<?php namespace App\Providers;

use App\Article;
use App\ArticleClassify;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider {

	/**
	 * This namespace is applied to the controller routes in your routes file.
	 *
	 * In addition, it is set as the URL generator's root namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'App\Http\Controllers';

	/**
	 * Define your route model bindings, pattern filters, etc.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function boot(Router $router)
	{
		parent::boot($router);
		$router->bind('classify',function($classify){
			$ArticleClass = ArticleClassify::where('article_classify_path',$classify)->first();
			if(is_null($ArticleClass)){
				$ArticleClass = false;
			}
			return $ArticleClass;
		});
		$router->bind('name',function($name){
			$Article = Article::where('article_title','like',$name."%")->first();
			if(is_null($Article)){
				$Article = false;
			}
			return $Article;
		});
		//
	}

	/**
	 * Define the routes for the application.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function map(Router $router)
	{
		$router->group(['namespace' => $this->namespace], function($router)
		{
			require app_path('Http/routes.php');
		});
	}

}
