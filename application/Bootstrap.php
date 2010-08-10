<?php

use \Zend\Application\Bootstrap as ZendBootstrap,
    \Doctrine\Common\ClassLoader,
    \Doctrine\ORM\Configuration,
    \Doctrine\ORM\EntityManager;

class Bootstrap extends ZendBootstrap
{
    public function _initDoctrine()
    {
        $classLoader = new ClassLoader('Doctrine');
        $classLoader->register();

        $config = new Configuration();
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
            'host' => 'db.murmp.com',
            'dbname' => 'bbm'
        );

        $em = EntityManager::create($connectionOptions,$config);

        return $em;
    }
}
