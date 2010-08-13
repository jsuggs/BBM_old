<?php

require_once __DIR__ . '/../lib/doctrine2/lib/vendor/doctrine-common/lib/Doctrine/Common/ClassLoader.php';

// Doctrine Setup

define('DOCTRINE_PATH', realpath(dirname(__FILE__) . '/../lib/doctrine2/lib'));
define('DATADIR', realpath(dirname(__FILE__). '/../data'));
define('PROXYDIR', realpath(dirname(__FILE__). '/generatedProxies'));

set_include_path(implode(PATH_SEPARATOR,array(
  realpath(DOCTRINE_PATH),
  realpath(DOCTRINE_PATH . '/vendor/doctrine-common/lib'),
  realpath(DOCTRINE_PATH . '/vendor/doctrine-dbal/lib'),
  realpath(DOCTRINE_PATH . '/vendor'),
  realpath(dirname(__FILE__) . '/..'),
  realpath(dirname(__FILE__) . '/Command'),
  get_include_path()
)));

$classLoader = new \Doctrine\Common\ClassLoader('Doctrine');
$classLoader->register();

$classLoader = new \Doctrine\Common\ClassLoader('Doctrine\ORM');
$classLoader->register();

$classLoader = new \Doctrine\Common\ClassLoader('Doctrine\Common');
$classLoader->register();

$classLoader = new \Doctrine\Common\ClassLoader('Doctrine\DBAL');
$classLoader->register();

$classLoader = new \Doctrine\Common\ClassLoader('Symfony');
$classLoader->register();

// BBM Specific Setup

$classLoader = new \Doctrine\Common\ClassLoader('BBM');
$classLoader->register();

$classLoader = new \Doctrine\Common\ClassLoader('BBM\Statistics');
$classLoader->register();

$classLoader = new \Doctrine\Common\ClassLoader('BBM\Command');
$classLoader->register();

$config = new \Doctrine\ORM\Configuration();
$config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache);
$config->setResultCacheImpl(new \Doctrine\Common\Cache\ArrayCache); 
$driverImpl = $config->newDefaultAnnotationDriver('/home/jsuggs/bbm/BBM');
$config->setMetadataDriverImpl($driverImpl);

$config->setProxyDir(PROXYDIR);
$config->setProxyNamespace('DoctrineProxies');

$connectionOptions = array(
    'driver' => 'pdo_pgsql',
    'user' => 'bbm',
    'password' => 'bbm',
    'host' => 'localhost',
    'dbname' => 'bbm'
);

$em = \Doctrine\ORM\EntityManager::create($connectionOptions, $config);

$helpers = array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
);
