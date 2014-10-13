<?php defined('COREPATH') or die('No direct script access.');

class Welcome extends \core\base\Controller {
	public function __construct()
	{
		parent::__construct();
	}

	public function index ()
	{
		echo 'action "index" called from welcome controller<br>';
		//$this->model->kasra();
		//$this->view->render('welcome');
	}
} 