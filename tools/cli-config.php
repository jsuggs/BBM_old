<?php

require_once __DIR__ . '/../lib/doctrine2/lib/vendor/doctrine-common/lib/Doctrine/Common/ClassLoader.php';

/*$classLoader = new \Doctrine\Common\ClassLoader('Entities', __DIR__ . '../BBM');
$classLoader->register();

$classLoader = new \Doctrine\Common\ClassLoader('Proxies', __DIR__ . '../BBM');
$classLoader->register();*/

$config = new \Doctrine\ORM\Configuration();
return;
$config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache);
$driverImpl = $config->newDefaultAnnotationDriver(array(__DIR__."/Entities"));
$config->setMetadataDriverImpl($driverImpl);
die('here');

$config->setProxyDir(__DIR__ . '/Proxies');
$config->setProxyNamespace('Proxies');

$connectionOptions = array(
    'driver' => 'pdo_sqlite',
    'path' => 'database.sqlite'
);

$em = \Doctrine\ORM\EntityManager::create($connectionOptions, $config);

$helpers = array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
);
