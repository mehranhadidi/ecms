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

// pars the address bar params to readable addresses like controller, method, param, etc.
$base_url = isset($_GET['url']) ? $_GET['url'] : null;
$base_url = rtrim($base_url, '/');
$base_url = explode('/', $base_url);

print_r($base_url);