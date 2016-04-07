<?php

namespace EvilLib\Factory;

class MailServiceFactory implements \Zend\ServiceManager\FactoryInterface
{

    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator
     * @return \EvilLib\Service\MailService
     * @throws \LogicException
     */
    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator)
    {
        $aConfig = $oServiceLocator->get('configuration');
        if (!array_key_exists('mail', $aConfig)) {
            throw new \LogicException('Config should contain an entry named "mail"');
        }
        if (!array_key_exists('connection', $aConfig['mail'])) {
            throw new \LogicException('Mail config should contain an entry named "connection"');
        }
        $aMailConfig = $aConfig['mail']['connection'];
        if (!array_key_exists('protocol', $aMailConfig)) {
            throw new \LogicException('Mail connection config should contain an entry named "protocol"');
        }
        if (!array_key_exists('options', $aMailConfig)) {
            throw new \LogicException('Mail connection config should contain an entry named "options"');
        }

        switch ($aMailConfig['protocol']) {
            case 'smtp':
                $oSmtpConfig = new \Zend\Mail\Transport\SmtpOptions($aMailConfig['options']);
                $oTransporter = new \Zend\Mail\Transport\Smtp($oSmtpConfig);
                break;
            default:
                throw new \LogicException('Invalid protocol or not implemented');
        }

        $oMailService = new \EvilLib\Service\MailService($oServiceLocator);
        $oMailService->setTransporter($oTransporter);

        return $oMailService;
    }
}
