<?php

/**
 * Base Controller class, Any other controllers will extends this class
 *
 * @author Mehran Hadidi
 */

namespace core\base;

class Controller {

	private $module = null;

	public function __construct()
	{
		//$this->module = $module;

		// create a view for the controller
		$this->view = new View();
	}

	public function loadModel($module)
	{
		// find out the model name
		$modelName = $this->findModelName();

		// find the model path file base on the "module" or "controller"
		$modelPath = ($module != null) ? MODPATH . $module . DS . 'models' . DS . $modelName . '.php' : APPPATH . 'classes' . DS . 'models' . DS . $modelName . '.php';

		if(file_exists($modelPath))
		{
			// load model
			require_once $modelPath;

			//
			$this->model = new $modelName();
		}
	}

	private function findModelName ()
	{
		return explode('_', get_class($this)) [0] . '_Model';
	}
}