<?php  
namespace Core;

class Common
{
	public static function &loaded_classes($class, $path, $param = null)
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
			exit("HAVE NOT SUCH FILE IN SYSTEM");
		}

		static::is_loaded($class, $path);

		$_classes[$class] = isset($param)
			? new $name($param)
			: new $name();
		return $_classes[$class];
		
	}

	public static function &is_loaded($class = '', $path = '')
	{
		static $_is_loaded = array();

		if ($class !== '')
		{
			$_is_loaded[$path] = $class;
		}

		return $_is_loaded;
		
	}
}