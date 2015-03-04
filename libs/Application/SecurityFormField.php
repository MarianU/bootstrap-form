<?php

namespace Application;

class SecurityFormField extends FormField
{
	protected $_form = null;
	private $_persistentName = null;

	public function __construct($name, $form)
	{
		$this->name = $name;
		$this->_persistentName = $form->name . '_' . $name;
		$this->type = 'hidden';
		$this->_form = $form;
		$this->previousValue = Persistent::get($this->_persistentName);
	}

	public function setValue($value)
	{
		$this->value = $value;
	}

	public function getValue()
	{
		$newValue = uniqid('crpt', true);
		Persistent::set($this->_persistentName, $newValue);

		return $newValue;
	}

	public function isValid($value = null)
	{
		if($value)
			$this->setValue($value);

		return ($this->previousValue == $this->value);
	}
}
