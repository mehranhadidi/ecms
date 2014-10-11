<?php

/**
 * Base View class, Any other views will extends this class
 *
 * @author Mehran Hadidi
 */

namespace core\base;

class View {

	private $header = 'header.php';
	private $footer = 'footer.php';

	public function __construct()
	{
	}

	/**
	 * This method will load view file base on the file name & module name:
	 *
	 * Example : render('ViewFileName', 'ModuleName');
	 *
	 * @note: ModuleName can be null
	 *
	 * @param $name
	 * @param null $module
	 */
	public function render ($name, $module = null)
	{
		// reformat name of the view file
		$name = $this->reFormatName($name);

		/*
		 * this part of code will check if any module called then will change view path from default path-
		 * to the module view path.
		 *
		 * Path:
		 *      Default Path = "~/application/classes/views/"
		 *      Modules Path = "~/modules/{MODULE_NAME}/views/"
		 *
		 */
		$viewFile_path = ($module != null) ? MODPATH . $module . DS . 'views' . DS : APPPATH . 'classes' . DS . 'views' . DS;

		// check if header file was exist load it
		if(file_exists($viewFile_path . $this->header))
			require_once $viewFile_path . $this->header;

		/**-------------------------------------------------------
		 *      Main View file
		 *
		 * check if main view file was exist load it,
		 * else show an error
		 *-------------------------------------------------------*/

		if(file_exists($viewFile_path . $name))
			require_once $viewFile_path . $name;
		else
			exit("View file doesn't exist in : "  . $viewFile_path . $name);

		// -------------------------------------------------------

		// check if footer file was exist load it
		if(file_exists($viewFile_path . $this->footer))
			require_once $viewFile_path . $this->footer;
	}

	/**
	 * This method will re format the view file name
	 *
	 * 1.upper case first letter
	 * 2.add ".php" to the end of the name
	 *
	 * @param $name
	 * @return string
	 */
	private function reFormatName ($name)
	{
		return ucfirst($name) . '.php';
	}
} 