<?php

define('EXT', '.php');

require_once 'Autoload' . '/' . 'Register' . EXT;
require_once 'Core' . '/' . 'Common' . EXT;

use App\activeRussian;
use Autoload\Register;
use Core\Container;
use Kernel\App;

new Register();
(new Container())->loading();

function &instance(){
	return Container::locker();
}
print_r(\Core\is_loaded());
$app = &instance();
print_r($app->russian);
// new App(new activeRussian('ChenQi', 27));