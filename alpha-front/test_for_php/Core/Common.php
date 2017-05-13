<?php  
namespace Core;

function &loaded_classes($class, $path, $param = null)
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

	$instance = '\\' . $path . '\\' . $class;

	$_classes[$class] = isset($param)
		? new $instance($param)
		: new $instance();
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

	is_loaded($class, $path);

	return;
}

function &is_loaded($class = '', $path = '')
{
	static $_is_loaded = array();

	if ($class !== '')
	{
		$_is_loaded['\\' . $path . '\\' . $class] = $class;
	}

	return $_is_loaded;
	
}