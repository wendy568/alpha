<?php

namespace acme;
use app\AppInterface;

 class chinese implements AppInterface
 {
 	public function speak()
 	{
 		echo 'hello, i\'m chinese';
 	}
 }
