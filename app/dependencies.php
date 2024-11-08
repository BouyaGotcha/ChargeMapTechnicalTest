<?php

use DI\ContainerBuilder;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Psr\Container\ContainerInterface;

const APP_ROOT = __DIR__ . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        EntityManager::class => function (ContainerInterface $container): EntityManager {
            $settings = $container->get('settings');

            $config = ORMSetup::createAttributeMetadataConfiguration(
                $settings['doctrine']['metadata_dirs'],
                $settings['doctrine']['dev_mode']
            );

            return new EntityManager(DriverManager::getConnection(
                $settings['database'],
                $config
            ), $config);
        }
    ]);
};
