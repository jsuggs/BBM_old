<?php

namespace DoctrineProxies;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class BBMStartingLineupProxy extends \BBM\StartingLineup implements \Doctrine\ORM\Proxy\Proxy
{
    private $_entityPersister;
    private $_identifier;
    public $__isInitialized__ = false;
    public function __construct($entityPersister, $identifier)
    {
        $this->_entityPersister = $entityPersister;
        $this->_identifier = $identifier;
    }
    private function _load()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;
            if ($this->_entityPersister->load($this->_identifier, $this) === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            unset($this->_entityPersister, $this->_identifier);
        }
    }

    
    public function getPitcher()
    {
        $this->_load();
        return parent::getPitcher();
    }

    public function setPitcher(\BBM\Player $pitcher)
    {
        $this->_load();
        return parent::setPitcher($pitcher);
    }


    public function __sleep()
    {
        return array('__isInitialized__', 'startinglineup_id', 'pitcher');
    }
}