<?php
namespace Autoload;

class Register
{

	public function __construct()
	{
		$this->Autoload();
	}

	public function Autoload()
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
		    'WebInterFace'    => 'Kernel',
		    				'TestInterFace'   => 'Kernel',
		    				'App'    		  => 'Kernel',
		    				'AppInterface'    => 'Kernel', 
		    				'FactoryAbstract' => 'Kernel',
		    				
		    			 ],
			];

		array_walk_recursive($required_classes, function ($val, $key) {
				$classes = &\Core\loaded_interfaceAbstracts($key, $val);
			});
	}

}
