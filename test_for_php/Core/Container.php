<?php
namespace Core;

class Container
{
	private static $_container;

	public function __contruct()
	{
		echo 12313;
		self::$_container = $this;

		array_walk(is_loaded(), function ($val, $key) {
			$this->$val = &\Core\loaded_classes($val, $key);
		});
		print_r(12313);
	}

	public static function &locker()
	{
		return self::$_container;
	}
}
