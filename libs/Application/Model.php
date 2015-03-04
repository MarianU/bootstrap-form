<?php

namespace Application;

class Model
{
	private static $_databaseLink = null;

	protected $_modelData;
	protected $_newModel = true;

	protected static $_columnId = 'id';
	protected static $_tableName = 'table';

	public static function connect($connection)
	{
		self::$_databaseLink = new \mysqli($connection['host'], $connection['username'], $connection['password'], $connection['database']);
	}

	public static function find($parameters = array())
	{
		$sql = self::createFindQuery($parameters);
		$result = self::executeQuery($sql);

		if($result)
		{
			$fetchedModels = array();
			$className = \get_called_class();

			while($row = $result->fetch_assoc())
			{
				$fetchedModels[] = static::create($row);
			}
			return $fetchedModels;
		}

		return null;
	}

	private static function createFindQuery($parameters = array())
	{
		$sql = "select ";
		if(isset($parameters['columns']))
			$sql .= $parameters['columns'];
		else
			$sql .= ' * ';

		$sql .= ' from `' . static::$_tableName . '`';

		if(isset($parameters['where']))
			$sql .= ' where ' . $parameters['where'];

		if(isset($parameters['order']))
			$sql .= ' order by ' . $parameters['order'];

		if(isset($parameters['limit']))
			$sql .= ' limit ' . $parameters['limit'];

		return $sql;
	}

	public function save()
	{
		$sql = $this->createUpdateQuery();
		return self::executeQuery($sql);
	}

	private function createUpdateQuery()
	{
		$columns = array();
		$sql = ($this->_newModel ? 'insert into ' : 'update') . "`" . static::$_tableName . "` set ";

		foreach($this->_modelData as $column => $value)
		{
			if($column == static::$_columnId)
				continue;

			$columns[] = "`$column` = '" . self::escape($value) . "'";
		}
		$sql .= join(',', $columns);

		$sql .= ($this->_newModel ? '' : "where id = '{$this->_modelData[static::$_columnId]}'");

		return $sql;
	}

	private static function executeQuery($sql)
	{
		return self::$_databaseLink->query($sql);
	}

	private static function escape($value)
	{
		return self::$_databaseLink->escape_string($value);
	}

	protected function setData($data)
	{
		$this->_modelData = $data;
	}

	public function __get($parameter)
	{
		if(isset($this->_modelData[$parameter]))
			return $this->_modelData[$parameter];

		return null;
	}
}
