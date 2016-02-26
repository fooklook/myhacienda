<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class BlogController extends Controller {

	public function detail($classify,$name){
		if($classify || $name){
			var_dump($name);
		}
	}

}
