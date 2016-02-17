<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class HookController extends Controller {

	public function storeEvents(Request $request) {
		$event_name = $request->header('X-Github-Event');
		$body = json_encode(Input::all());

		$hook = new Hook;
		$hook->event_name = $event_name;
		$hook->payload = $body;

		$hook->save();

		return "";// 200 OK
	}

}
