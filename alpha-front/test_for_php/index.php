<?php

define('EXT', '.php');

require_once 'Autoload' . '/' . 'Register' . EXT;
require_once 'Core' . '/' . 'Common' . EXT;

use Autoload\Register;
use Core\Common;

(new Register(new Common()))->Autoload();
print_r(Container::is_loaded());
// new App(new activeRussian('ChenQi', 27));