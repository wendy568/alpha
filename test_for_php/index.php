<?php

define('EXT', '.php');

require_once 'Autoload' . '/' . 'Register' . EXT;
require_once 'Core' . '/' . 'Common' . EXT;

use Autoload\Register;
use Core\Container;

(new Register())->Autoload();
// print_r(\Core\loaded_classes('Container', 'Core'));
function &instance(){
	return Container::locker();
}
print_r(instance());
// new App(new activeRussian('ChenQi', 27));