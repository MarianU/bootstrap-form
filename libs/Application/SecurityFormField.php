<?php

namespace Application;

class SecurityFormField extends FormField
{
	private $_persistentName = null;

	public function __construct($name, $form)
	{
		parent::__construct($name, $form);
		$this->_persistentName = $form->name . '_' . $name;
		$this->type = 'hidden';
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
