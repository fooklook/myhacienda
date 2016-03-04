<?php namespace App\Commands;

/**
 * 延时同步文件内容
 */
use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;

class SyncFile extends Command implements SelfHandling {
	private $action;
	private $sync;
	private $filename;
	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($action, $sync, $filename)
	{
		$this->action = $action;
		$this->sync = $sync;
		$this->filename = $filename;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
		$sync = $this->sync;
		$action = $this->action;
		$filename = $this->filename;
		$sync->$action($filename);
	}

}
