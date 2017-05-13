<?php

define('EXT', '.php');

require_once 'Autoload' . '/' . 'Register' . EXT;
require_once 'Core' . '/' . 'Common' . EXT;
require_once 'Core' . '/' . 'Container' . EXT;

use Autoload\Register;
use Core\Common;

Register::Autoload(new Common());
// new app(new activeRussian('ChenQi', 27));