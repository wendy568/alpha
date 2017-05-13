<?php
namespace Autoload;

use Core\Common;

class Register
{
	private $_loader;

	public function __construct(Common $loader)
	{
		$this->_loader = $loader;
		$this->loaded_interfaceAbstracts();
	}

	public function Autoload()
	{
		$loader = $this->_loader;

		$required_classes = [
			'core'    => [
							'Core'   => 'Container'
						 ],
			'kernel'  => [
							'Kernel' => 'App',
						 ],
		    'App'     => [
		    				'App'    => 'activeRussian',
		    			    'App'    => 'russian'
		    			 ],
			];

		array_walk_recursive($required_classes, function ($val, $key) use ($loader) {
				$classes = &$loader::loaded_classes($val, $key);
			});
	}

	private function loaded_interfaceAbstracts()
	{
		$loader = $this->_loader;
		$interfaceAbstract = [
			'kernel'  => [
							'Kernel' => 'AppInterface', 
							'Kernel' => 'FactoryAbstract',
							'Kernel' => 'WebInterFace',
							'Kernel' => 'TestInterFace'
						 ],
			];

			array_walk_recursive($required_classes, function ($val, $key) use ($loader) {
					$interfaceAbstracts = &$loader::loaded_interfaceAbstracts($val, $key);
				});
	}
}
