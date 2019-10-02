<?php

// Base path
define('BASE_PATH', str_replace('\\', '/', __DIR__));

// Default paths
define('START_PATH', realpath(__DIR__ . '/../'));
define('APP_PATH', realpath(__DIR__ . '/../app'));
define('CONFIG_PATH', realpath(__DIR__ . '/../config'));
define('RESOURCES_PATH', realpath(__DIR__ . '/../resources'));
define('ROUTES_PATH', realpath(__DIR__ . '/../routes'));
define('STORAGE_PATH', realpath(__DIR__ . '/../storage'));
define('VENDOR_PATH', realpath(__DIR__ . '/../vendor'));


$domainExt = pathinfo($_SERVER['SERVER_NAME'], PATHINFO_EXTENSION);

// Define the language
switch ($domainExt) {
    case 'com':
        setlocale(LC_ALL, 'en_US.UTF-8');
        setlocale(LC_MONETARY, 'en_US');
        define('LANGUAGE_CODE', 'en');
        define('LANGUAGE_ID', 2);
        define('LANGUAGE_NAME', 'English');
        break;

    default:
        setlocale(LC_ALL, 'nl_NL');
        setlocale(LC_MONETARY, 'de_DE');
        define('LANGUAGE_CODE', 'nl');
        define('LANGUAGE_ID', 1);
        define('LANGUAGE_NAME', 'Dutch');
        break;
}
