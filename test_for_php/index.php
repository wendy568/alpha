<?php

define('EXT', '.php');

require_once 'Autoload' . '/' . 'Register' . EXT;
require_once 'Core' . '/' . 'Common' . EXT;

use Autoload\Register;
use Core\Container;

new Register();
new Container();

function &instance(){
	return Container::locker();
}
print_r(\Core\is_loaded());
print_r(instance());
// new App(new activeRussian('ChenQi', 27));