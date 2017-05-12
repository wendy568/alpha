<?php
namespace Autoload;

use Core\Common;

class Register
{
	public static function Autoload(Common $loader)
	{
		$required_classes = [
			'app' => ['Core\Container' => 'Container'],
			];
		array_walk_recursive($required_classes, function ($val, $key){
				$temp = &$loader::loaded_classes($val, $key);
			});
	}
}
