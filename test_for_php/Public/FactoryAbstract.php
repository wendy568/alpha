<?php  
namespace app;


abstract class FactoryAbstract{
	private $name;
	private $age;

	public function __construct($name, $age)
	{
		$this->name = $name;
		$this->age = $age;
	}

	public function whoIAm()
	{
		echo "I\'m {$this->name}";
	}

	abstract protected function age();

}