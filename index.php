<?php

/**
 * eCMS is an open source iFramework built in php.
 *
 * @author      cruelcap, biodread
 * @copyright	Copyright (c) 2008 - 2014
 * @license     MIT
 * @link        http://mehranhadidi.com, http://asdeveloper.com
 * @version     1.0.0
 */

// ------------------------------------------------------------------------

/**------------------------------------------------------------------------
 *      APPLICATION  ENVIRONMENT
 *------------------------------------------------------------------------*
 *
 * You can load different configurations depending on your
 * current environment. Setting the environment also influences
 * things like logging and error reporting.
 *
 * This can be set to anything, but default usage is:
 *
 *     development
 *     testing
 *     production
 *
 * NOTE: If you change these, also change the error_reporting() code below
 *
 */

define('ENVIRONMENT', 'development');

/**------------------------------------------------------------------------
 *      ERROR REPORTING
 *------------------------------------------------------------------------*
 *
 * Different environments will require different levels of error reporting.
 * By default development will show errors but testing and live will hide them.
 *
 */

if (defined('ENVIRONMENT'))
{
	switch(ENVIRONMENT)
	{
		case 'development':
			error_reporting(E_ALL);
			break;

		case 'testing':
		case 'production':
			error_reporting(0);
			break;

		default:
			exit('The application environment is not set correctly.');
	}
}

/**------------------------------------------------------------------------
 *      DIRECTORY CONSTANTS
 *------------------------------------------------------------------------*/

$application    = 'application';
$modules        = 'modules';
$core           = 'core';

// directory separator base on operating system
define('DS', DIRECTORY_SEPARATOR);

// project base path
define('BASEPATH', dirname(__FILE__) . DS);

// make the application relative to the base path, for symlink'd index.php
if(is_dir($application) && is_dir(BASEPATH . $application))
	define('APPPATH', BASEPATH . $application . DS);

// make the modules relative to the base path, for symlink'd index.php
if(is_dir($modules) && is_dir(BASEPATH . $modules))
	define('MODPATH', BASEPATH . $modules . DS);

// make the modules relative to the base path, for symlink'd index.php
if(is_dir($core) && is_dir(BASEPATH . $core))
	define('COREPATH', BASEPATH . $core . DS);

unset($application, $modules, $core);

/**------------------------------------------------------------------------
 *      INSTALLATION
 *------------------------------------------------------------------------*/

/*
 * check if there was any install.php in the project root then load it to check
 * apache & php configs
 */

//TODO initialise install.php

/*if(file_exists(BASEPATH . 'install.php'))
	return require_once BASEPATH . 'install.php';*/


/**------------------------------------------------------------------------
 *      LOAD THE BOOTSTRAP FILE
 *------------------------------------------------------------------------*/

if(file_exists(APPPATH . 'Bootstrap.php'))
	require_once PPPATH . 'Bootstrap.php';
else
	exit('Bootstrap.php not found!');