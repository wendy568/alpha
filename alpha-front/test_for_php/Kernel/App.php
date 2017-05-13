<?php  

namespace Kernel;
use Kernel\AppInterface;

class App
{

	protected $app;

	public function __construct(AppInterface $app)
	{
		$this->app = $app;
		$this->app->speak();
	}

	public function speak()
	{
		echo 'i\m a Public One';
	}
}