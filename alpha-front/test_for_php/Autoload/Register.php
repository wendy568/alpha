<?php
namespace Autoload;

use Core\Common;

class Register
{
	public static function Autoload(Common $loader)
	{
		$required_classes = [
			'app'    => ['Core'   => 'Container'],
			'public' => ['Public' => 'AppInterface', 
						 'Public' => 'app'],
			];

		array_walk_recursive($required_classes, function ($val, $key) use ($loader) {
				$temp = &$loader::loaded_classes($val, $key);
			});
	}
}
