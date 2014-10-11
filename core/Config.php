<?php

/**
 * Load Configuration files from application
 * @note: all of config files should have ".config.php" at the end of their names.
 *
 * @autor: Mehran Hadidi
 */

class Config
{
	/**
	 * check if config file was exist load it,
	 * if was not available throw an error
	 *
	 * @param $name
	 */
	public static function ATTACH ($name, $smart = false)
	{
		$config_path = APPPATH . 'configs' . DS . $name . '.config.php';

		if(file_exists($config_path))
			require_once $config_path;
		elseif($smart)
			exit('Config file not found:' . $config_path);
	}

	/**
	 * check if config file was exist load it,
	 * if was not available don't do anything
	 *
	 * @param $name
	 */
	public static function SMART_ATTACH($name)
	{
		$config_path = APPPATH . 'configs' . DS . $name . '.config.php';
		self::ATTACH($name, true);
	}
}