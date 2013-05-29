<?php
defined('APPLICATION_PATH')
    || define(
        'APPLICATION_PATH',
        realpath(dirname(__FILE__) . '/../../application')
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

use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper,
    Symfony\Component\Console\Helper\HelperSet,
    Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;

// Starting application
$app = new \Yaf\Application(APPLICATION_PATH . "/configs/application.ini");
$app->bootstrap();

// obtaining the entity manager
$entityManager = \Yaf\Registry::get('EntityManager');

$helperSet = new HelperSet(array(
    'db' => new ConnectionHelper($entityManager->getConnection()),
    'em' => new EntityManagerHelper($entityManager)
));
