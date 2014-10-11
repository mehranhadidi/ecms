<?php

/**
 * Database class is a new business layer on top of PHP PDO library.
 *
 * this class will use by models
 *
 * @autor: Mehran Hadidi
 */

namespace core\database;

class Database extends \PDO {
	public function __construct($DB_TYPE, $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS)
	{
		parent::__construct($DB_TYPE.':host='.$DB_HOST.';dbname='.$DB_NAME, $DB_USER, $DB_PASS);
	}
} 