<?php

namespace Application;

class Form implements \ArrayAccess, \Iterator
{
	private $_fields = array();
	private $_isSubmited = false;

	public function __construct($name = null)
	{
		$this->name = $name;
	}

	public function addField(FormField $field)
	{
		if($field->name == null)
			$name = '_' . rand();
		else
			$name = $field->name;

		if(isset($this->_fields[$name]))
			throw new \Exception("Duplicate form field name '$name'.");

		$this->_fields[$name] = $field;
	}

	public function isValid($formData = null)
	{
		$this->_isSubmited = true;
		if($formData === null)
			return $this->_isValid;

		if(empty($this->_fields))
			return null;

		$this->_isValid = true;
		foreach($this->_fields as $fieldName => $field)
		{
			if(!$field->isValid(isset($formData[$fieldName]) ? $formData[$fieldName] : null))
				$this->_isValid = false;
		}

		return $this->_isValid;
	}

	public function isSubmited()
	{
		return $this->_isSubmited;
	}

	public function getData()
	{
		if(empty($this->_fields))
			return null;

		$formData = array();
		foreach($this->_fields as $fieldName => $field)
		{
			$formData[$fieldName] = $field->getValue();
		}

		return $formData;
	}

	public function clearValue()
	{
		foreach($this->_fields as $fieldName => $field)
		{
			$field->clearValue();
		}
	}

	public function rewind()
	{
		\reset($this->_fields);
	}

	public function current()
	{
		return \current($this->_fields);
	}

	public function key()
	{
		return \key($this->_fields);
	}

	public function next()
	{
		return \next($this->_fields);
	}

	public function valid()
	{
		$key = $this->key();

		return ($key !== NULL && $key !== FALSE);
	}

	public function offsetExists($field)
	{
		return isset($this->_fields[$field]);
	}

	public function offsetGet($field)
	{
		return $this->offsetExists($field) ? $this->_fields[$field] : null;
	}

	public function offsetSet($field, $value)
	{
		$this->_fields[$field] = $value;
	}

	public function offsetUnset($field)
	{
		unset($this->_fields[$field]);
	}
/*
	public function __get($field)
	{
		if(isset($this->_fields[$field]))
			return $this->_fields[$field];

		return null;
	}*/

}
