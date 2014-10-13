<?php

/**
 * Database class is a new business layer on top of PHP PDO library.
 *
 * this class will use by models
 *
 * @author: Mehran Hadidi
 */

namespace core\database;

class Database extends \PDO {
	public function __construct($DB_TYPE, $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS)
	{
		parent::__construct($DB_TYPE.':host='.$DB_HOST.';dbname='.$DB_NAME, $DB_USER, $DB_PASS);

		// if you want to show PDO errors uncomment this line below
		//parent::setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
	}

	/**
	 * insert
	 * @param string $table name of the table to insert into
	 * @param string $data  data in associative array
	 * @return bool
	 */
	public function insert ($table, $data)
	{
		// sort data
		ksort($data);

		// fix data structure according to SQL Query
		$fieldNames = implode(", ", array_keys($data));
		$fieldValues = ':' . implode(", :", array_keys($data));

		// prepare the sql query
		$sth = $this->prepare("INSERT INTO $table ($fieldNames) VALUES ($fieldValues)");

		// bind the prepared data to the original data (sql injection ignoring)
		foreach ($data as $key => $value)
		{
			$sth->bindValue($key, $value);
		}

		// execute the query
		return $sth->execute();


	}

	/**
	 * @param string $table  name of table
	 * @param string $data   data in associative array
	 * @param string $where  the WHERE query part
	 * @return bool
	 */
	public function update ($table, $data, $where)
	{
		// sort data
		ksort($data);

		$fieldDetails = NULL;

		// generate field details according to original data entered
		foreach ($data as $key => $value)
		{
			$fieldDetails .= "$key=:$key,";
		}

		// fix last "'" in the field name
		$fieldDetails = rtrim($fieldDetails, ',');

		// prepare the sql query
		$sth = $this->prepare("UPDATE $table SET $fieldDetails WHERE $where");

		// bind the prepared data to the original data (sql injection ignoring)
		foreach ($data as $key => $value)
		{
			$sth->bindValue($key, $value);
		}

		// execute the query
		return $sth->execute();
	}

	/**
	 * delete
	 * @param string $table name of table
	 * @param string $where  the WHERE query part
	 * @return bool
	 */
	public function delete ($table, $where)
	{
		// prepare the sql query
		$sth = $this->prepare("DELETE FROM $table WHERE $where");

		// execute the query
		return $sth->execute();
	}
} 