<?php  
namespace Core;

function &loaded_classes($class, $path, $param = null)
{

	static $_classes = array();

	if (isset($_classes[$class]))
	{
		return $_classes[$class];
	}

	// $name = str_replace('\\', '/', $path) . '/' . $class;
	// if (file_exists(realpath($name . EXT))) {
	// 	require_once "{$name}" . EXT;
	// }else{
	// 	exit("HAVE NOT SUCH {$name} IN SYSTEM");
	// }

	is_loaded($class, $path);

	$_classes[$class] = isset($param)
		? new $class($param)
		: new $class();
	return $_classes[$class];
	
}

function &loaded_lib($class, $path)
{

	static $_classes = array();

	if (isset($_classes[$class]))
	{
		return $_classes[$class];
	}

	$name = str_replace('\\', '/', $path) . '/' . $class;
	if (file_exists(realpath($name . EXT))) {
		require_once "{$name}" . EXT;
	}else{
		exit("HAVE NOT SUCH {$name} IN SYSTEM");
	}

	is_loaded($class, $path);

	$_classes[$class] = $path;
	return $_classes[$class];
}

function &loaded_interfaceAbstracts($class, $path)
{

	static $_classes = array();

	if (isset($_classes[$class]))
	{
		return $_classes[$class];
	}

	$name = str_replace('\\', '/', $path) . '/' . $class;
	if (file_exists(realpath($name . EXT))) {
		require_once "{$name}" . EXT;
	}else{
		exit("HAVE NOT SUCH {$name} IN SYSTEM");
	}

	$_classes[$class] = $path;
	return $_classes[$class];
}

function &is_loaded($class = '', $path = '')
{
	static $_is_loaded = array();

	if ($class !== '')
	{
		$_is_loaded[$class] = $path;
	}

	return $_is_loaded;
	
}