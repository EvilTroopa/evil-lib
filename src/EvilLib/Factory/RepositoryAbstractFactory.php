<?php

namespace EvilLib\Factory;

class RepositoryAbstractFactory implements \Zend\ServiceManager\AbstractFactoryInterface
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

        return class_exists($sRequestedName) && is_subclass_of($sRequestedName, '\EvilLib\Repository\AbstractEntityRepository');
    }

    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator
     * @param string $sName
     * @param string $sRequestedName
     * @return \Application\Repository\AbstractEntityRepository
     */
    public function createServiceWithName(\Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator, $sName, $sRequestedName)
    {
        $oEntityManager = $oServiceLocator->get('\Doctrine\ORM\EntityManager');

        // Parse Entity class name
        $sEntityName = str_replace('Repository', 'Entity', $sRequestedName);

        if (!class_exists($sEntityName) || !is_subclass_of($sEntityName, '\EvilLib\Entity\AbstractEntity')) {
            throw new \LogicException('Class "' . $sEntityName . '" linked to repository "' . $sRequestedName . '" does not exist');
        }

        return new $sRequestedName($oEntityManager, new \Doctrine\ORM\Mapping\ClassMetadata($sEntityName));
    }
}
