<?php

use DI\ContainerBuilder;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Psr\Container\ContainerInterface;

const APP_ROOT = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        EntityManager::class => function (ContainerInterface $container): EntityManager {
            $config = ORMSetup::createAttributeMetadataConfiguration(
                [APP_ROOT . '/src/Domain'],
                true
            );

            return new EntityManager(DriverManager::getConnection(
                [
                    'driver' => 'pdo_mysql',
                    'host' => 'localhost',
                    'port' => 3306,
                    'dbname' => 'charge-map',
                    'user' => 'user',
                    'password' => 'secret',
                    'charset' => 'utf8'
                ],
                $config
            ), $config);
        }
    ]);
};
