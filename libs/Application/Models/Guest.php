<?php

namespace Application\Models;

use Application\Model;

class Guest extends Model
{
	protected static $_columnId = 'id';
	protected static $_tableName = 'guests';

	public function __construct()
	{
		$this->_modelData = array();
	}

	static public function create($data)
	{
		$instance = new Guest();
		if(isset($data['date']))
			$data['date'] = date('d.m.Y', strtotime($data['date']));
		$instance->setData($data);

		return $instance;
	}

}