<?php

class instance {

	/**
	 * Reference to the singleton
	 *
	 * @var	object
	 */
	private static $instance;

	/**
	 * Class constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		self::$instance =& $this;

		// Assign all the class objects that were instantiated by the
		// bootstrap file (CodeIgniter.php) to local class variables
		// so that CI can run as one big super object.
		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Get the singleton
	 *
	 * @static
	 * @return	object
	 */
	public static function &get_instance()
	{
		return self::$instance;
	}

}

function &load_class($class, $param = null)
{

	static $_classes = array();

	// Does the class exist? If so, we're done...
	if (isset($_classes[$class]))
	{
		return $_classes[$class];
	}

	// Keep track of what we just loaded
	is_loaded($class);

	$_classes[$class] = isset($param)
		? new $class($param)
		: new $class();
	return $_classes[$class];
	
}

function &is_loaded($class = '')
{
	static $_is_loaded = array();

	if ($class !== '')
	{
		$_is_loaded[strtolower($class)] = $class;
	}

	return $_is_loaded;
}

function &get_instance()
{
	return instance::get_instance();
}

// class A
// {
// 	function hi()
// 	{
// 		echo ' Hi ';
// 	}
// }

// class B
// {
// 	function name()
// 	{
// 		echo ' Chenqi ';
// 	}
// }

$a = &load_class('A');
$b = &load_class('B');

$test = &get_instance();
// print_r(is_loaded());
$test->hi();
