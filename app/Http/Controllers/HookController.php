<?php namespace App\Http\Controllers;

use App\Hook;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Lib\Sync_console;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class HookController extends Controller {

	public function storeEvents(Request $request) {
		$sync = new Sync_console($request);
		$sync->action();
	}

}
