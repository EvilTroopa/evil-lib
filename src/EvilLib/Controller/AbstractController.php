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
    protected $serviceManager;

    /**
     * @return \Zend\ServiceManager\ServiceLocatorInterface
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $oServiceManager
     * @return \EvilLib\Controller\AbstractController
     */
    public function setServiceManager(\Zend\ServiceManager\ServiceLocatorInterface $oServiceManager)
    {
        $this->serviceManager = $oServiceManager;
        return $this;
    }
}
