<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace EvilLib;

class Module
{

    public function onBootstrap(\Zend\Mvc\MvcEvent $oEvent)
    {
        $oServiceLocator = $oEvent->getApplication()->getServiceManager();
        $aConfig = $oServiceLocator->get('configuration');
        if (!array_key_exists('translator', $aConfig)) {
            throw new \LogicException('Config should contain an entry named "translator"');
        }

        if (!array_key_exists('fallback_locale', $aConfig['translator']) || !is_string($aConfig['translator']['fallback_locale']) || !\Locale::getDisplayName($aConfig['translator']['fallback_locale'])) {
            throw new \LogicException('Config translator "fallback_locale" expects a valid locale string value, "' . gettype($aConfig['translator']['fallback_locale']) . '" given' . (is_string($aConfig['translator']['fallback_locale']) ? '' : ', value : "' . $aConfig['translator']['fallback_locale'] . '"'));
        }

        $oTranslator = $oServiceLocator->get('MvcTranslator');
        $oTranslator->setLocale(\Locale::acceptFromHttp($oEvent->getRequest()->getServer('HTTP_ACCEPT_LANGUAGE')))
                ->setFallbackLocale($aConfig['translator']['fallback_locale']);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
