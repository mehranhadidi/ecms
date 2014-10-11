<?php defined('COREPATH') or die('No direct script access.');

/**
 * Auto Loaders
 *
 * This file will create all of the custom autoloaders to load all of the called php base on the air.
 *
 * Full documentation listed below:
 * @link http://php.net/manual/en/function.spl-autoload-register.php
 * @link http://www.php-fig.org/psr/psr-0/
 */

function autoload($className)
{
	// Namespace Example: \Zend\Mail\Message => /path/to/project/lib/vendor/Zend/Mail/Message.php

	$className = ltrim($className, '\\');
	$fileName  = '';
	$namespace = '';
	if ($lastNsPos = strrpos($className, '\\')) {
		$namespace = substr($className, 0, $lastNsPos);
		$className = substr($className, $lastNsPos + 1);
		$fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
	}
	$fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

	require $fileName;
}

spl_autoload_register('autoload');