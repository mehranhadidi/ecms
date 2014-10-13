<?php defined('COREPATH') or die('No direct script access.');

/**
 * Set the default time zone.
 *
 * @link http://www.php.net/manual/timezones
 */
date_default_timezone_set('Asia/Tehran');

/**
 * Set the default locale.
 *
 * @link http://www.php.net/manual/function.setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Include the Autoloaders
 */
require_once COREPATH . 'Autoloader.php';

/**
 * Load Configs
 */
Config::SMART_ATTACH('database');

// ------------------------------------------------------------------------

/*
 * instantiate the application
 */
$app = App::getInstance();
$app->init(array(
	// default controller
	'controller'                => 'Welcome',

	// default action
	'action'                    => 'index',

	// default module controller
	'module_controller'         => 'Welcome_Module',

	// default module action
	'module_action'             => 'index',

	//TODO: separate default module action from the all module default action
));

$user = new \core\database\DBObject('users');
$user->findById(4);

var_dump($user);