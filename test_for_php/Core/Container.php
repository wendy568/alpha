<?php
namespace Core;

use Core\Common;

class Container
{
	private static $_container;

	public function __contruct()
	{
		static::$_container = $this;

		array_walk(Common::is_loaded(), function ($val, $key) {
			$this->$val = &Common::loaded_classes($val,$key);
		});
	}

	public static function &locker()
	{
		return Container::$_container;
	}
}
