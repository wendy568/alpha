<?php
namespace acme;

use app\FactoryAbstract;
use app\WebInterFace;
use app\app;

abstract class russian extends FactoryAbstract implements WebInterFace
{
	public function speak()
	{
		$this->whoIAm();
		echo ',Hello';
	}

	// protected function age()
	// {
	// 	echo $this->age;
	// }

	public function test()
	{
		
	}
}