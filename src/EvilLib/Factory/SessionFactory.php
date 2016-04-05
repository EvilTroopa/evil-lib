<?php

namespace EvilLib\Factory;

class SessionFactory implements \Zend\ServiceManager\FactoryInterface
{

    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator
     * @return \EvilLib\Form\SignUpForm
     * @throws \LogicException
     */
    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator)
    {
        $aConfig = $oServiceLocator->get('configuration');
        if (!array_key_exists('session', $aConfig)) {
            throw new \LogicException('Config should contain an entry named "session"');
        }

        $oSessionConfig = new \Zend\Session\Config\SessionConfig();
        $oSessionConfig->setOptions($aConfig['session']);
        $oSessionManager = new \Zend\Session\SessionManager($oSessionConfig);
        \Zend\Session\Container::setDefaultManager($oSessionManager);
        $oSessionManager->start(true);

        return $oSessionManager;
    }
}
