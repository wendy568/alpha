<?php

namespace acme;
use Kernel\AppInterface;

 class acme implements AppInterface
 {
 	public function speak()
 	{
 		echo 'hello, i\'m acme';
 	}
 }
