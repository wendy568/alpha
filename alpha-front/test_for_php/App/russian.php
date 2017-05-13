<?php
namespace App;

use kernel\FactoryAbstract;
use kernel\WebInterFace;
use kernel\app;

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