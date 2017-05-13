<?php
namespace Autoload;

use Core\loaded_classes;
use Core\loaded_interfaceAbstracts;

class Register
{

	public function __construct()
	{
		$this->loaded_interfaceAbstracts();
	}

	public function Autoload()
	{
		$required_classes = [
			'core'    => [
							'Container'     => 'Core'
						 ],
			// 'kernel'  => [
			// 				'App'           => 'Kernel',
			// 			 ],
		    // 'App'     => [
		    // 				'activeRussian' => 'App',
		    // 			    'russian'       => 'App'
		    // 			 ],
			];

		array_walk_recursive($required_classes, function ($val, $key) {
				$classes = &loaded_classes($key, $val);
			});
	}

	private function loaded_interfaceAbstracts()
	{
		$interfaceAbstract = [
			'kernel'  => [
							// 'TestInterFace'   => 'Kernel',
							'AppInterface'    => 'Kernel', 
							'FactoryAbstract' => 'Kernel',
							// 'WebInterFace'    => 'Kernel',
						 ],
			];

		array_walk_recursive($interfaceAbstract, function ($val, $key) {
				$interfaceAbstracts = &loaded_interfaceAbstracts($key, $val);
			});
	}
}
