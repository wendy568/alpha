<?php
namespace Autoload;

class Register
{

	public function __construct()
	{
		$this->load_core();
		$this->Autoload();
	}

	private function Autoload()
	{
		$required_classes = [
			
		    'App'     => [
		    				'russian'       => 'App',
		    				'activeRussian' => 'App',
		    			 ],
		    'kernel'  => [
		    				'App'    		  => 'Kernel',
		    			 ],
		    'core'    => [
							'Container'     => 'Core'
						 ],
			];

		array_walk_recursive($required_classes, function ($val, $key) {
				$classes = &\Core\loaded_lib($key, $val);
			});
	}

	private function load_core()
	{

		$required_classes = [
		    'kernel'  => [
		    				'AppInterface'    => 'Kernel',
		    				'TestInterFace'   => 'Kernel',
		    				'FactoryAbstract' => 'Kernel',
		    				'WebInterFace'    => 'Kernel',
		    			 ],
			];

		array_walk_recursive($required_classes, function ($val, $key) {
				$classes = &\Core\loaded_interfaceAbstracts($key, $val);
			});
		
	}

}
