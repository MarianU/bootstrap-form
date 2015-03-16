<?php

namespace Application;

class View
{
	const VIEWS_DIRECTORY = 'Application/Views/';

	private $_viewData = array();
	private $_viewFile = null;

	public function setRenderFile($viewFileName)
	{
		$this->_viewFile = $viewFileName;
	}

	public function render()
	{
		if(!empty($this->_viewFile))
		{
			if(!include self::VIEWS_DIRECTORY . $this->_viewFile)
				throw new \Exception("View file '{$this->_viewFile}' is missing.");
		}
	}

	public function captureStart()
	{
		ob_start();
	}

	public function captureDestroy()
	{
		ob_end_clean();
	}

	public function captureReturn()
	{
		$contents = ob_get_contents();
		$this->captureDestroy();

		return $contents;
	}

	public function __get($parameter)
	{
		if(isset($this->_viewData[$parameter]))
		{
			return $this->_viewData[$parameter];
		}

		return null;
	}

	public function __set($parameter, $value)
	{
		$this->_viewData[$parameter] = $value;
	}
}