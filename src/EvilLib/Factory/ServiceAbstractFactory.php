<?php

namespace EvilLib\Factory;

class ServiceAbstractFactory implements \Zend\ServiceManager\AbstractFactoryInterface
{

    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator
     * @param string $sName
     * @param string $sRequestedName
     * @return boolean
     */
    public function canCreateServiceWithName(\Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator, $sName, $sRequestedName)
    {
        if (!is_string($sName)) {
            throw new \InvalidArgumentException('Argument $sName expects a string value, "' . gettype($sName) . '" given');
        }
        if (!is_string($sRequestedName)) {
            throw new \InvalidArgumentException('Argument $sRequestedName expects a string value, "' . gettype($sRequestedName) . '" given');
        }

        return class_exists($sRequestedName) && is_subclass_of($sRequestedName, '\EvilLib\Service\AbstractService');
    }

    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator
     * @param string $sName
     * @param string $sRequestedName
     * @return \Application\Service\AbstractService
     */
    public function createServiceWithName(\Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator, $sName, $sRequestedName)
    {
        return new $sRequestedName($oServiceLocator);
    }
}
