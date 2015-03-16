<?php

namespace Application;

class Controller
{
	protected $_view = null;

	public function __construct($view)
	{
		$this->_view = $view;
	}
}
