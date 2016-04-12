<?php

namespace EvilLib\Controller;

/**
 * Description of AbstractController
 *
 * @author EvilTroopa
 */
class AbstractController extends \Zend\Mvc\Controller\AbstractActionController
{

    /**
     * @var \Zend\ServiceManager\ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * @return \Zend\ServiceManager\ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator
     * @return \EvilLib\Controller\AbstractController
     */
    public function setServiceLocator(\Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator)
    {
        $this->serviceLocator = $oServiceLocator;
        return $this;
    }
}
