<?php

class Application
{
	const DEFAULT_ACTION = 'index:index';
	const ACTION_SUFIX = 'Action';
	const DEFAULT_METHOD = 'index';
	const APPLICATION_PATH = 'Application';
	const CONTROLLERS_PATH = 'Controllers';
	const VIEWS_PATH = 'View';
	const MODULES_PATH = 'Module';
	const ACTION_PARAMETER = 'action';

	private $_view;

	private $_pageQuery;
	private $_requestedAction;
	private $_controlerClassName;
	private $_methodName;

	function __construct()
	{
		$this->_view = new Application\View();
	}

	static function setupLoader()
	{
		\spl_autoload_register(array('\Application', 'autoLoad'));
	}

	public static function autoLoad($class)
	{
		$file = str_replace('\\', '/', $class) . '.php';
		if (!include $file)
		{
			throw new \Exception("Failed Loading class '$class'");
		}
	}

	function run()
	{
		$this->_view->captureStart();

		$this->parseInput();
		$this->routeRequest();
		$this->executeController();
	}

	private function parseInput()
	{
		$this->_pageQuery = $_GET;

		if(isset($this->_pageQuery[self::ACTION_PARAMETER]))
			$this->_requestedAction = $this->_pageQuery[self::ACTION_PARAMETER];
		else
			$this->_requestedAction = self::DEFAULT_ACTION;
	}

	private function routeRequest()
	{
		$actionParts = explode(':', $this->_requestedAction);
		$controlerName = addslashes(ucfirst($actionParts[0]));

		if(isset($actionParts[1]))
			$this->_methodName = addslashes($actionParts[1]);
		else
			$this->_methodName = self::DEFAULT_METHOD;

		$this->_controlerClassName = self::APPLICATION_PATH . '\\' . self::CONTROLLERS_PATH . '\\' . $controlerName;
	}

	private function executeController()
	{
		$controler = new $this->_controlerClassName($this->_view);

		if(method_exists($controler, $this->_methodName . self::ACTION_SUFIX))
		{
			if(call_user_func(array($controler, $this->_methodName . self::ACTION_SUFIX)))
			{
				$this->_view->render();
			}
		}
		else
		{
			throw new \Exception('Action requested does not exist');
		}
	}

	public function render()
	{
		return $this->_view->captureReturn();
	}
}