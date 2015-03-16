<?php

namespace Application\Controllers;

use Application\Controller,
	Application\Persistent,
	Application\Form,
	Application\FormField,
	Application\SecurityFormField,
	Application\CaptchaFormField,
	Application\Models\Guest;

class Index extends Controller
{
	private $_form = null;


	public function __construct($view)
	{
		parent::__construct($view);
		$this->setupForm();
	}

	private function setupForm()
	{
		$this->_form = new Form('guest');

		$name = new FormField('name', $this->_form);
		$name->label = 'Name';
		$name->tooltipMessage = 'Please enter your name at least 3 characters long.';
		$name->type = 'text';
		$name->setValidator(FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/.{3,}/')));
		$name->setSanitizer(FILTER_SANITIZE_STRING);
		$this->_form->addField($name);

		$email = new FormField('email', $this->_form);
		$email->label = 'Email';
		$email->tooltipMessage = 'Please enter a valid Email address.';
		$email->type = 'email';
		$email->setValidator(FILTER_VALIDATE_EMAIL);
		$email->setSanitizer(FILTER_SANITIZE_EMAIL);
		$this->_form->addField($email);

		$message = new FormField('message', $this->_form);
		$message->label = 'Message';
		$message->tooltipMessage = 'Please enter a message at least 5 characters long.';
		$message->type = "textarea";
		$message->setValidator(FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/.{5,}/')));
		$message->setSanitizer(FILTER_SANITIZE_STRING);
		$this->_form->addField($message);

		$security = new SecurityFormField('secure', $this->_form);
		$this->_form->addField($security);

		$captcha = new CaptchaFormField('g-recaptcha-response', $this->_form);
		$this->_form->addField($captcha);
	}

	public function indexAction()
	{
		return $this->guestAction();
	}

	public function guestAction()
	{
		if(!empty($_POST))
		{
			if($this->_form->isValid($_POST))
			{
				$formData = $this->_form->getData();
				unset($formData['secure'], $formData['g-recaptcha-response']);
				$guest = Guest::create($formData);
				$guest->save();

				$this->_form->clearValue();
				$this->_view->succesMessage = 'Thank you for your input';
			}
			else
				$this->_view->errorMessage = 'Please check input fields for errors';
		}

		$this->_view->form = $this->_form;

		$this->_view->setRenderFile('guestForm.php');

		$this->listAction();

		return true;
	}

	public function listAction()
	{
		$this->_view->records = Guest::find(array('order' => 'date desc'));

		return true;
	}

}

