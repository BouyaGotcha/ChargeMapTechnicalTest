<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\DBAL\DriverManager;

$config = new PhpFile('migrations.php');

$settings = require __DIR__ . '/settings.php';
$settings = $settings['settings'];

$ORMConfig = ORMSetup::createAttributeMetadataConfiguration(
    $settings['doctrine']['metadata_dirs'],
    $settings['doctrine']['dev_mode']
);
$connection = DriverManager::getConnection([
    'driver' => $settings['database']['driver'],
    'memory' => true
]);

$entityManager = new EntityManager($connection, $ORMConfig);

return DependencyFactory::fromEntityManager($config, new ExistingEntityManager($entityManager));