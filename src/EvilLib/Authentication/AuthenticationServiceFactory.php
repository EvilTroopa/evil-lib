<?php

/*
 * The MIT License
 *
 * Copyright 2016 EvilTroopa.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace EvilLib\Authentication;

/**
 * Description of AuthenticationServiceFactory
 *
 * @author EvilTroopa
 */
class AuthenticationServiceFactory implements \Zend\ServiceManager\FactoryInterface
{

    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator
     * @return \EvilLib\Authentication\AuthenticationService
     * @throws \LogicException
     */
    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator)
    {
        $aConfig = $oServiceLocator->get('configuration');

        // Retrieve authentication config
        if (!array_key_exists('authentication', $aConfig)) {
            throw new \LogicException('Configuration should contain an entry named "authentication"');
        }
        $aAuthenticationConfig = $aConfig['authentication'];

        // Retrieve authentication storage config
        if (!array_key_exists('storage', $aAuthenticationConfig)) {
            throw new \LogicException('Authentication configuration should contain an entry named "storage"');
        }
        $aStorageConfig = $aAuthenticationConfig['storage'];
        // Validate storage config
        if (!array_key_exists('namespace', $aStorageConfig) || !is_string($aStorageConfig['namespace'])) {
            throw new \LogicException('Authentication storage configuration should contain an entry named "namespace" of type string');
        }
        if (!array_key_exists('member', $aStorageConfig) || !is_string($aStorageConfig['member'])) {
            throw new \LogicException('Authentication storage configuration should contain an entry named "member" of type string');
        }

        // Retrieve authentication adapter config
        if (!array_key_exists('adapter', $aAuthenticationConfig)) {
            throw new \LogicException('Authentication configuration should contain an entry named "adapter"');
        }
        $aAdapterConfig = $aAuthenticationConfig['adapter'];
        // Validate adapter config
        $aExpectedKeys = array('object_manager', 'object_repository', 'identity_class', 'identity_property', 'credential_property', 'credential_callable');
        if (!empty(array_diff(array_keys($aAdapterConfig), $aExpectedKeys))) {
            throw new \LogicException('Adapter Config should contain these keys "' . implode(', ', $aExpectedKeys) . '", given : "' . implode(', ', array_keys($aAdapterConfig)) . '"');
        }
        // Convert adapter config data
        foreach ($aAdapterConfig as $sKey => $sConfig) {
            if (is_string($sConfig)) {
                if ($oServiceLocator->has($sConfig)) {
                    $aAdapterConfig[$sKey] = $oServiceLocator->get($sConfig);
                }
            } else if (is_array($sConfig)) {
                if ($oServiceLocator->has($sConfig[0])) {
                    $sConfig[0] = $oServiceLocator->get($sConfig[0]);
                    $aAdapterConfig[$sKey] = $sConfig;
                }
            }
        }


        // Instanciate storage
        $oStorage = new \Zend\Authentication\Storage\Session($aStorageConfig['namespace'], $aStorageConfig['member']);
        // Instanciate adapter
        $oAdapter = new \DoctrineModule\Authentication\Adapter\ObjectRepository($aAdapterConfig);

        return new \EvilLib\Authentication\AuthenticationService(new \Zend\Authentication\AuthenticationService($oStorage, $oAdapter));
    }
}
