<?php
namespace Autoload;

use Core\Common;

class Register
{
	public static function Autoload(Common $loader)
	{
		array_walk_recursive([
			['Core\Container' => 'Container'],
			], function ($val, $key){
				$temp = &$loader::loaded_classes($val, $key);
			});
	}
}
