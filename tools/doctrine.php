<?php

$vendorDir = __DIR__ . '../lib/doctrine2/lib/vendor/';
require __DIR__ . '/../lib/doctrine2/lib/vendor/doctrine-common/lib/Doctrine/Common/ClassLoader.php';

define('DOCTRINE_PATH', realpath(dirname(__FILE__) . '/../lib/doctrine2/lib'));

set_include_path(implode(PATH_SEPARATOR,array(
  realpath(DOCTRINE_PATH),
  realpath(DOCTRINE_PATH . '/vendor/doctrine-common/lib'),
  realpath(DOCTRINE_PATH . '/vendor/doctrine-dbal/lib'),
  realpath(DOCTRINE_PATH . '/vendor'),
  realpath(dirname(__FILE__) . '/..'),
  get_include_path()
)));

$classLoader = new \Doctrine\Common\ClassLoader('Doctrine');//, __DIR__ . '/../lib/doctrine2/lib');
$classLoader->register();

$classLoader = new \Doctrine\Common\ClassLoader('Doctrine\ORM'); //, __DIR__ . '../lib/doctrine2/lib/Doctrine/ORM');
$classLoader->register();

$classLoader = new \Doctrine\Common\ClassLoader('Doctrine\Common'); //, $vendorDir . 'doctrine-common/lib');
$classLoader->register();

$classLoader = new \Doctrine\Common\ClassLoader('Doctrine\DBAL'); //, $vendorDir . 'doctrine-dbal/lib');
$classLoader->register();

$classLoader = new \Doctrine\Common\ClassLoader('Symfony');
$classLoader->register();

// Variable $helperSet is defined inside cli-config.php
require __DIR__ . '/cli-config.php';

$cli = new \Symfony\Components\Console\Application('Doctrine Command Line Interface', Doctrine\Common\Version::VERSION);
$cli->setCatchExceptions(true);
$helperSet = $cli->getHelperSet();
foreach ($helpers as $name => $helper) {
    $helperSet->set($helper, $name);
}
$cli->addCommands(array(
    // DBAL Commands
    new \Doctrine\DBAL\Tools\Console\Command\RunSqlCommand(),
    new \Doctrine\DBAL\Tools\Console\Command\ImportCommand(),

    // ORM Commands
    new \Doctrine\ORM\Tools\Console\Command\ClearCache\MetadataCommand(),
    new \Doctrine\ORM\Tools\Console\Command\ClearCache\ResultCommand(),
    new \Doctrine\ORM\Tools\Console\Command\ClearCache\QueryCommand(),
    new \Doctrine\ORM\Tools\Console\Command\SchemaTool\CreateCommand(),
    new \Doctrine\ORM\Tools\Console\Command\SchemaTool\UpdateCommand(),
    new \Doctrine\ORM\Tools\Console\Command\SchemaTool\DropCommand(),
    new \Doctrine\ORM\Tools\Console\Command\EnsureProductionSettingsCommand(),
    new \Doctrine\ORM\Tools\Console\Command\ConvertDoctrine1SchemaCommand(),
    new \Doctrine\ORM\Tools\Console\Command\GenerateRepositoriesCommand(),
    new \Doctrine\ORM\Tools\Console\Command\GenerateEntitiesCommand(),
    new \Doctrine\ORM\Tools\Console\Command\GenerateProxiesCommand(),
    new \Doctrine\ORM\Tools\Console\Command\ConvertMappingCommand(),
    new \Doctrine\ORM\Tools\Console\Command\RunDqlCommand(),
    new \Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand(),

));
$cli->run();
