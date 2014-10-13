<?php

/**
 * DBObject is a class that will create a schema from database table to PHP Object (DBObject = Database Object)
 *
 * This class can handle :
 *      Set & Get variables dynamically
 *      (private) Create
 *      (private) Update
 *      Save
 *      FindAll
 *
 *      & Dump Data
 *
 * @author: Mehran Hadidi
 *
 */

namespace core\database;

class DBObject {
	private $data;
	private $table;
	private $db;

	/**
	 *
	 * @param string $table name of the table
	 */
	public function __construct($table)
	{
		// active an database connection
		$this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);

		// set table name
		$this->table = $table;
	}

	/**
	 * This method will call when user request to read a variable of an object
	 *
	 * @param string $varName
	 * @return string
	 * @throws Exception
	 */
	public function __get($varName)
	{
		if (!array_key_exists($varName,$this->data))
		{
			// if object variable dosn't exist throw an error
			throw new Exception('this attribute is not defined!');
		}
		else
		{
			// if exist return the variable value
			return $this->data[$varName];
		}
	}

	/**
	 * This method will call when user request to put a new variable to an object
	 *
	 * @param string $varName name of the variable
	 * @param string $value value of the variable
	 */
	public function __set($varName,$value)
	{
		// define that variable
		$this->data[$varName] = $value;
	}

	/**
	 * Create a new object
	 */
	private function create ()
	{
		$this->db->insert($this->table, $this->data);
	}

	/**
	 * Update an existing object
	 */
	private function update ()
	{
		$this->db->update($this->table, $this->data, "id={$this->data['id']}");
	}


	/**
	 * Save DBObject
	 */
	public function save ()
	{
		if(isset($this->data['id']))
		{
			// if object is exists then update it
			$this->update();
		}
		else
		{
			// if object doesn't exist create new one
			$this->create();
		}
	}

	public function findAll ($requestedFields = "*")
	{
		$sth = $this->db->prepare("SELECT $requestedFields FROM $this->table");
		$sth->setFetchMode(\PDO::FETCH_ASSOC);
		$sth->execute();
		$data = $sth->fetchAll();

		//var_dump($this->instantiate($data));

		return $this->instantiate($data);
		//var_dump($this->data);
	}

	public function findByField ($condition, $requestedFields = "*")
	{
		$sth = $this->db->prepare("SELECT $requestedFields FROM $this->table WHERE $condition");
		$sth->setFetchMode(\PDO::FETCH_ASSOC);
		$sth->execute();
		$data = $sth->fetchAll();

		return $this->instantiate($data);
	}

	public function findById ($id, $requestedFields = "*")
	{
		if($id <= 0)
			die("ID must be hight than 0");

		return $this->findByField('id='.$id, $requestedFields);
	}

	private function instantiate ($data)
	{
		// if query executed
		if(count($data) > 0)
		{
			if(count($data) == 1)
			{
				foreach($data[0] as $key => $value)
				{
					$this->data[$key] = $value;
				}
			}
			else
			{
				for($i = 0; $i < count($data); $i++)
				{
					$subdata = array();
					foreach($data[$i] as $key => $value)
					{
						$subdata[$key] = $value;
					}
					$obj = new DBObject($this->table);
					$obj->push($subdata);
					$this->data[$i] = $obj;
				}
			}
		}

		//var_dump($this->data);

		// if any result founded
		if(count($this->data) > 0)
		{
			// something pushed
			if(count($this->data) == 1)
			{
				return true;
			}
			else
			{
				return $this->data;
			}
		}
		else
			return false; // didn't do anything
	}

	public function push ($data)
	{
		if(is_array($data))
		{
			foreach($data as $key => $value)
			{
				$this->data[$key] = $value;
			}
		}
	}

	/**
	 * Dump an object
	 */
	public function dump ()
	{
		echo '<pre>';
		var_dump($this->data);
		echo '</pre>';
	}
} 