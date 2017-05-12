<?php  

namespace app;
use app\AppInterface;

class app
{

	protected $app;

	public function __construct(AppInterface $app)
	{
		$this->app = $app;
		$this->app->speak();
	}

	public function speak()
	{
		echo 'i\m a app';
	}
}