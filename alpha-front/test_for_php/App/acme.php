<?php

namespace acme;
use app\AppInterface;

 class acme implements AppInterface
 {
 	public function speak()
 	{
 		echo 'hello, i\'m acme';
 	}
 }
