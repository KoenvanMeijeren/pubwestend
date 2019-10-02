<?php
// set the constants
require_once __DIR__ . '/config/const.php';

// load the functions
require_once APP_PATH . '/functions.php';

// autoload the classes
require_once VENDOR_PATH . '/autoload.php';

// load the website and debug
\App\services\core\App::run();
