<?php

use Autoload\Register;

define(EXT, '.php');

require_once 'Autoload' . '/' . 'Register.php';
require_once 'Core' . '/' . 'Common.php';


Register::Autoload(new Common());
// new app(new activeRussian('ChenQi', 27));