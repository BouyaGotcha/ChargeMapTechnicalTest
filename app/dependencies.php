<?php

use App\Repository\ChargeRepository;
use App\Repository\UserRepository;
use DI\ContainerBuilder;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Psr\Container\ContainerInterface;
use Ramsey\Uuid\Doctrine\UuidGenerator;

const APP_ROOT = __DIR__ . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR;

\Doctrine\DBAL\Types\Type::addType('uuid', 'Ramsey\Uuid\Doctrine\UuidType');

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
        },
        UserRepository::class => function (ContainerInterface $container): UserRepository {
            return new UserRepository($container->get(EntityManager::class));
        },
        ChargeRepository::class => function (ContainerInterface $container): ChargeRepository {
            return new ChargeRepository($container->get(EntityManager::class));
        },
    ]);
};
