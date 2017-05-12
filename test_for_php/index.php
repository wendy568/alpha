<?php


define('EXT', '.php');

require_once 'Autoload' . '/' . 'Register.php';
require_once 'Core' . '/' . 'Common.php';

use Autoload\Register;


Register::Autoload(new Common());
// new app(new activeRussian('ChenQi', 27));