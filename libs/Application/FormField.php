<?php

namespace Application;

class FormField
{
	protected $_form = null;
	protected $_fieldData = array();
	protected $_valid = false;
	protected $_validator = FILTER_DEFAULT;
	protected $_validatorOptions = null;
	protected $_sanitizer = null;
	protected $_sanitizerOptions = null;


	public function __construct($name, $form)
	{
		$this->name = $name;
		$this->_form = $form;
	}

	public function setValidator($validator, $options = null)
	{
		$this->_validator = $validator;
		$this->_validatorOptions = $options;
	}

	public function setSanitizer($sanitizer, $options = null)
	{
		$this->_sanitizer = $sanitizer;
		$this->_sanitizerOptions = $options;
	}

	public function setValue($value)
	{
		$this->_valid = false;
		$this->_unsafeValue = $value;

		if($this->_sanitizer)
			$this->value = filter_var($this->_unsafeValue, $this->_sanitizer, $this->_sanitizerOptions);
		else
			$this->value = $this->_unsafeValue;
	}

	public function getValue()
	{
		return $this->value;
	}

	public function clearValue()
	{
		$this->value = $this->_unsafeValue = null;
	}

	public function isValid($value = null)
	{
		if($value)
			$this->setValue($value);

		if($this->_valid)
			return true;

		if($this->_validator)
			$this->_valid = (bool)filter_var($this->_unsafeValue, $this->_validator, $this->_validatorOptions);
		else
			$this->_valid = true;

		return $this->_valid;
	}

	public function __get($parameter)
	{
		if(isset($this->_fieldData[$parameter]))
			return $this->_fieldData[$parameter];

		return null;
	}

	public function __set($parameter, $value)
	{
		$this->_fieldData[$parameter] = $value;
	}

}
