<?php

// Define root path
use DI\ContainerBuilder;

defined('DS') ?: define('DS', DIRECTORY_SEPARATOR);
defined('ROOT') ?: define('ROOT', dirname(__DIR__) . DS);

// Load .env file
$dotenv = Dotenv\Dotenv::createImmutable(ROOT . DS . 'app');
$dotenv->load();

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        'settings' => [
            'displayErrorDetails' => getenv('APP_DEBUG') === 'true', // set to false in production

            // Database settings
            'doctrine' => [
                'metadata_dirs' => [ROOT . DS . 'app' . DS . 'src' . DS . 'Domain',],
                'dev_mode' => true,
            ],

            'database' => [
                'driver' => 'pdo_mysql',
                'host' => $_ENV['DB_HOST'],
                'dbname' => $_ENV['DB_DATABASE'],
                'user' => $_ENV['DB_USERNAME'],
                'password' => $_ENV['DB_PASSWORD'],
                'port' => $_ENV['DB_PORT'],
                'charset' => 'utf8',
            ]
        ],
    ]);
};
