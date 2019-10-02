<?php

use App\services\core\Config;

/******** DATABASE ********/
Config::set('databaseName', '');
Config::set('databaseUsername', '');
Config::set('databasePassword', '');
Config::set('databaseServer', 'mysql:host=localhost');
Config::set('databasePort', '3306');
Config::set('databaseCharset', 'utf8mb4');
Config::set('databaseOptions', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

/******** MAIL ********/
Config::set('mailDebug', true);
Config::set('mailHost', '');
Config::set('mailUsername', '');
Config::set('mailPassword', '');
Config::set('mailPort', '');