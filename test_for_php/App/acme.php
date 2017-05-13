<?php

namespace acme;
use Public\AppInterface;

 class acme implements AppInterface
 {
 	public function speak()
 	{
 		echo 'hello, i\'m acme';
 	}
 }
