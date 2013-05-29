<?php
// Define path to application directory
defined('APPLICATION_PATH')
    || define(
        'APPLICATION_PATH',
        realpath(dirname(__FILE__) . '/../application')
);

// Define application environment
define('APPLICATION_ENV', 'testing');

// Starting application
$app = new \Yaf\Application(APPLICATION_PATH . "/configs/application.ini");

// Running bootstrap
//$app->bootstrap();

$config = $app->getConfig();

$namespaces = $config->application->namespaces->toArray();

\Yaf\Loader::getInstance()->registerLocalNameSpace($namespaces);