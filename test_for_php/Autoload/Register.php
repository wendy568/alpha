<?php
namespace Autoload;

use Core\Common;

class Register
{
	private $_loader;

	public function __construct(Common $loader)
	{
		$this->_loader = $loader;
		// $this->loaded_interfaceAbstracts();
	}

	public function Autoload()
	{
		$loader = $this->_loader;

		$required_classes = [
			'core'    => [
							'Container'     => 'Core'
						 ],
			'kernel'  => [
							'App'           => 'Kernel',
						 ],
		    'App'     => [
		    				'activeRussian' => 'App',
		    			    'russian'       => 'App'
		    			 ],
			];

		array_walk_recursive($required_classes, function ($val, $key) use ($loader) {
				$classes = &$loader::loaded_classes($key, $val);
			});
	}

	private function loaded_interfaceAbstracts()
	{
		$loader = $this->_loader;
		$interfaceAbstract = [
			'kernel'  => [
							'AppInterface'    => 'Kernel', 
							'FactoryAbstract' => 'Kernel',
							'WebInterFace'    => 'Kernel',
							'TestInterFace'   => 'Kernel'
						 ],
			];

		array_walk_recursive($interfaceAbstract, function ($val, $key) use ($loader) {
				$interfaceAbstracts = &$loader::loaded_interfaceAbstracts($key, $val);
			});
	}
}
