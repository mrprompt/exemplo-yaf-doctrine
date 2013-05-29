<?php
// Define path to application directory
defined('APPLICATION_PATH')
    || define(
        'APPLICATION_PATH', 
        realpath(dirname(__FILE__) . '/../application')
);

// Define application environment
defined('APPLICATION_ENV')
    || define(
        'APPLICATION_ENV', (
        getenv('APPLICATION_ENV') ? 
        getenv('APPLICATION_ENV') : 
        'production'
    )
);

// autoloading
require_once __DIR__ . '/../vendor/autoload.php';

// Starting application
$app = new \Yaf\Application(APPLICATION_PATH . "/configs/application.ini");

// Running bootstrap
$app->bootstrap()
    ->run();
