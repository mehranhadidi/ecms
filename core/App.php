<?php defined('COREPATH') or die('No direct script access.');

/**
 * Class App
 *
 * This is the main App class.
 * current running module, language, controller & action will be pointed to this class instance
 */

class App
{
	// singleton instance
	public static $instance;

	private $url;
	private $default_controller;
	private $default_action;
	private $default_module_controller;
	private $default_module_action;

	private $module;
	private $controller;
	private $action;
	private $param;

	// Singleton Instantiate
	public static function getInstance ()
	{
		if( ! isset(App::$instance))
			App::$instance = new App();

		return App::$instance;
	}

	private function __construct ()
	{
		/** This method should be private because of the Singleton pattern */
	}

	/**
	 * Initialize the application
	 *  This method will do the items below :
	 *      1.Parse the URI
	 */
	public function init ($default_values)
	{
		// Define default controller & action
		if(is_array($default_values))
		{
			$this->default_controller           = $default_values['controller'];
			$this->default_action               = $default_values['action'];

			$this->default_module_controller    = $default_values['module_controller'];
			$this->default_module_action        = $default_values['module_action'];
		}

		// Parse the URI
		$this->parse_uri();

		// Parse Behaviors
		$this->parse_behaviors();
	}

	/**
	 * Parse the URI
	 *
	 * this method will parse the address bar params to readable addresses like controller, method, param, etc...
     * this method also will get the page uri directly.
	 */
	private function parse_uri ()
	{
		// if url is defined then get it
		$url = isset($_GET['url']) ? $_GET['url'] : null;

		// remove the right "/" from the string
		$url = rtrim($url, '/');

		// explode the string to the array base on "/"
		$url = explode('/', $url);

		// make uri accessible all over the class
		$this->url = $url;
	}

	/**
	 * Parse Behaviors
	 *
	 * this method will find out the modules, controllers, actions & params.
	 */
	private function parse_behaviors ()
	{
		/**-------------------------------------------------------------------------------
		 * if address bar was empty of parameters use the default controller & action
		 *-------------------------------------------------------------------------------*/
		if(empty($this->url[0]))
		{
			$controller_file = APPPATH . 'classes' . DS . 'controllers' . DS . $this->default_controller . '.php';

			if(file_exists($controller_file))
			{
				// load controller
				require_once $controller_file;

				$this->controller = $this->default_controller;
				$this->action = $this->default_module_action;

				// call the controller
				$controller = new $this->default_controller();

				// load Model
				$controller->loadModel($this->module);

				// if default method was exist in the controller call it else throw an error
				if(method_exists($controller, $this->default_action))
				{
					$action = $this->default_action;
					$controller->$action();
				}
				else
				{
					exit("default action doesn't exist in the default controller: <br> Controller:<strong>" . $this->default_controller . "</strong> :: Missing Method: &rarr; <strong>" . $this->default_action . "</strong>");
				}
			}
			else
				exit("default controller doesn't exist: " . $controller_file);
		}
		else
		{
			/**-------------------------------------------------------------------------------
			 * if address bar was not empty
			 *-------------------------------------------------------------------------------*/

			// check for module
			if($this->is_Module($this->url[0]))
			{
				// Module --------------------------------------------------------------------

				// find-out module controller & action
				$this->controller = (isset($this->url[1]) ? $this->url[1] : $this->default_module_controller );
				$this->action = (isset($this->url[2]) ? $this->url[2] : $this->default_module_action );
				$this->param = (isset($this->url[3]) ? $this->url[3] : null );

				// find controller file path
				$controller_file = MODPATH . $this->module . DS . 'controllers' . DS . $this->controller . '.php';

				if(file_exists($controller_file))
				{
					// load module controller file
					require_once $controller_file;

					// new the module controller
					$controller = new $this->controller();

					// load Model
					$controller->loadModel($this->module);

					// check for default method
					if(method_exists($controller, $this->action))
					{
						$action = $this->action;
						if($this->param != null)
							$controller->$action( $this->param );
						else
							$controller->$action();
					}
					else
					{
						exit("default action doesn't exist in the module default controller: <br> Controller:<strong>" . $this->controller . "</strong> :: Missing Method: &rarr; <strong>" . $this->action . "</strong>");
					}
				}
				else
				{
					exit("default module controller doesn't exist: " . $controller_file);
				}
			}
			else
			{
				// Not Module --------------------------------------------------------------------

				// find-out controller & action
				$this->controller = (isset($this->url[0]) ? $this->url[0] : $this->default_controller );
				$this->action = (isset($this->url[1]) ? $this->url[1] : $this->default_action );
				$this->param = (isset($this->url[2]) ? $this->url[2] : null );

				// cont
				$controller_file = APPPATH . 'classes' . DS . 'controllers' . DS . $this->controller . '.php';

				if(file_exists($controller_file))
				{
					// load controller file
					require_once $controller_file;

					// new the controller
					$controller = new $this->controller;

					// load Model
					$controller->loadModel($this->module);

					// check for action
					if(method_exists($controller, $this->action))
					{
						$action = $this->action;

						if($this->param != null)
							$controller->$action( $this->param );
						else
							$controller->$action();
					}
					else
					{
						exit("action doesn't exist in the controller: <br> Controller:<strong>" . $this->controller . "</strong> :: Missing Method: &rarr; <strong>" . $this->action . "</strong>");
					}
				}
				else
				{
					exit("controller doesn't exist: " . $controller_file);
				}
			}
		}
	}

	/**
	 * check if any module was called set it & then return result
	 *
	 * @param $name
	 * @return bool
	 */
	private function is_Module ($name)
	{
		if(file_exists(MODPATH . $name))
		{
			$this->module = $name;
			return true;
		}
		else
		{
			$this->module = null;
			return false;
		}
	}
} 