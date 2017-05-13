<?php
namespace Core;

class Container
{
	private static $_container;

	public function loading()
	{
		self::$_container = $this;

		array_walk(is_loaded(), function ($val, $key) {
			$this->$key = &\Core\loaded_classes($key, $val);
		});
	}

	public static function &locker()
	{
		return self::$_container;
	}
}
