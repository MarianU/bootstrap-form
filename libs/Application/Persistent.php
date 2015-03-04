<?php

namespace Application;

class Persistent
{
	protected static $_data = null;

	public static function init()
	{
		\session_start();
	}

	public static function get($parameter)
	{
		if(isset($_SESSION[$parameter]))
			return $_SESSION[$parameter];

		return null;
	}

	public static function set($parameter, $value)
	{
		$_SESSION[$parameter] = $value;
	}
}
