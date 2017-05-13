<?php
namespace Autoload;

class Register
{

	public function __construct()
	{
		$this->Autoload();
	}

	private function Autoload()
	{
		$required_classes = [
			'core'    => [
							'Container'     => 'Core'
						 ],
		    // 'App'     => [
		    // 				'activeRussian' => 'App',
		    // 			    'russian'       => 'App'
		    // 			 ],
		    'kernel'  => [
		    				'TestInterFace'   => 'Kernel',
		    				'App'    		  => 'Kernel',
		    				'AppInterface'    => 'Kernel', 
		    				'FactoryAbstract' => 'Kernel',
		    				'WebInterFace'    => 'Kernel',
		    			 ],
			];

		array_walk_recursive($required_classes, function ($val, $key) {
				$classes = &\Core\loaded_interfaceAbstracts($key, $val);
			});
	}

	private function load_core()
	{

		$required_classes = [
		    'kernel'  => [
		    				'AppInterface'    => 'Kernel',
		    				'TestInterFace'   => 'Kernel',
		    				'App'    		  => 'Kernel',
		    				'FactoryAbstract' => 'Kernel',
		    				'WebInterFace'    => 'Kernel',
		    			 ],
			];

		array_walk_recursive($required_classes, function ($val, $key) {
				$classes = &\Core\loaded_interfaceAbstracts($key, $val);
			});
		
	}

}
