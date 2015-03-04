<?php

namespace Application;

class CaptchaFormField extends FormField
{
	private $_captchaPersistentName = 'check_for_robots';
	private $_allowedInputs = 3;
	private $_currentInput = null;

	public function __construct($name, $form)
	{
		parent::__construct($name, $form);
		$this->type = 'render';
		$this->_currentInput = Persistent::get($this->_captchaPersistentName);
	}

	public function setAllowedInputs($allowed)
	{
		$this->_allowedInputs = $allowed;
	}

	public function isValid($value = null)
	{
		if($this->_valid)
			return $this->_valid;

		Persistent::set($this->_captchaPersistentName, Persistent::get($this->_captchaPersistentName)+1);

		if($this->_currentInput < $this->_allowedInputs)
		{
			$this->_valid = true;
			return $this->_valid;
		}

		$postData = http_build_query(array(
				'secret' => '6LdM_QITAAAAAONnNnoK-LJIF64KwyUN3YSpNCER',
				'response' => $value,
				'remoteip' => $_SERVER['REMOTE_ADDR']
		));
		$options = array(
				'http' => array(
						'method' => "POST",
						'content' => $postData,
						'header' => array(
								'Content-Length' => strlen($postData),
								'Content-type' => 'application/x-www-form-urlencoded',
						)
		));

		$context = stream_context_create($options);
		$rawResult = @file_get_contents("https://www.google.com/recaptcha/api/siteverify", false, $context);

		if(!$rawResult)
			return false;

		$result = json_decode(utf8_encode($rawResult));
		$this->_valid = $result->success;

		return $this->_valid;
	}

	public function render()
	{
		if($this->_currentInput >= $this->_allowedInputs)
			return '<div class="g-recaptcha" data-sitekey="6LdM_QITAAAAAGtKwFWXVwbDeGNwRBmkHb4pWn4-"></div>';

		return '';
	}
}
