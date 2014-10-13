<?php defined('COREPATH') or die('No direct script access.');

class Welcome_Model extends \core\base\Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function kasra ()
	{
		echo 'hello kasra';
	}
} 