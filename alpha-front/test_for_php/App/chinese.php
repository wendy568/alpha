<?php

namespace acme;
use Kernel\AppInterface;

 class chinese implements AppInterface
 {
 	public function speak()
 	{
 		echo 'hello, i\'m chinese';
 	}
 }
