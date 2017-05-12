<?php  

trait struct
{
	public function test()
	{
		parent::test();
		echo 'world';
	}
}