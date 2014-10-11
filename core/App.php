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
	public function init ()
	{
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

	}
} 