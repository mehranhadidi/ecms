<?php defined('COREPATH') or die('No direct script access.');

class User extends \core\base\Controller {
	public function __construct()
	{
		parent::__construct();
	}

	public function index ()
	{
		echo 'Module "apanel" :action "index" called from User controller';
	}
} 