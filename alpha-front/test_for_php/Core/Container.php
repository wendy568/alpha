<?php
namespace Core;

use Core\Common;

class Container
{
	private static $_container;

	public function __contruct()
	{
		static::$_container = $this;

		array_walk(is_loaded(), function ($val, $key) {
			$this->$val = &loaded_classes($val, $key);
		});
	}

	public static function &locker()
	{
		return Container::$_container;
	}
}
