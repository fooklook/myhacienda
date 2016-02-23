<?php namespace App\Http\Controllers;

use App\Hook;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class HookController extends Controller {

	public function storeEvents(Request $request) {
		$event_name = $request->header('X-Hub-Signature');
		var_dump($event_name);
		var_dump(Input::all());
		$body = Input::all();

		return "ok";// 200 OK
	}

}
