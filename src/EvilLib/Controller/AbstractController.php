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
     * @return \Zend\ServiceManager\ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }
}
