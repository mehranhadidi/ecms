<?php

/**
 * Base Model class, Any other models will extends this class
 *
 * @author Mehran Hadidi
 */

namespace core\base;

class Model {
	public function __construct()
	{
		$this->db = new \core\database\Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
	}
} 