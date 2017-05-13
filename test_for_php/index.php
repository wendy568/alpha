<?php

define('EXT', '.php');

require_once 'Autoload' . '/' . 'Register' . EXT;
require_once 'Core' . '/' . 'Common' . EXT;

use Autoload\Register;
use Core\Common;

(new Register(new Common()))->loaded_interfaceAbstracts();
(new Register(new Common()))->Autoload();
new App(new activeRussian('ChenQi', 27));