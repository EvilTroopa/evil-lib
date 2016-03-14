<?php

namespace EvilLib\Factory;

class EncryptionServiceFactory implements \Zend\ServiceManager\FactoryInterface
{

    /**
     * @param \Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator
     * @return \EvilLib\Service\EncryptionService
     * @throws \LogicException
     */
    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $oServiceLocator)
    {

        // Retrieve config
        $aConfig = $oServiceLocator->get('configuration');
        if (!array_key_exists('encryption', $aConfig)) {
            throw new \LogicException('Configuration should contain an entry named "encryption"');
        }

        // Retrieve Hash config
        if (!array_key_exists('hash', $aConfig['encryption'])) {
            throw new \LogicException('Encryption configuration should contain an entry named "hash"');
        }
        $aHashConfig = $aConfig['encryption']['hash'];

        // Retrieve Encrypt config
        if (!array_key_exists('encrypt', $aConfig['encryption'])) {
            throw new \LogicException('Encryption configuration should contain an entry named "encrypt"');
        }
        $aEncryptConfig = $aConfig['encryption']['encrypt'];

        // Instanciate Hash
        // Check config
        if (!array_key_exists('class', $aHashConfig)) {
            throw new \LogicException('Hash config should contain an entry named "class"');
        }
        $sHashClass = $aHashConfig['class'];
        if (!array_key_exists('options', $aHashConfig)) {
            throw new \LogicException('Hash config should contain an entry named "options"');
        }
        $aHashOptions = $aHashConfig['options'];
        // Check hash options
        if (!array_key_exists('algo', $aHashOptions)) {
            throw new \LogicException('Hash options config should contain an entry named "algo"');
        }
        if (!array_key_exists('loops', $aHashOptions)) {
            throw new \LogicException('Hash options config should contain an entry named "loops"');
        }
        if (!array_key_exists('salt', $aHashOptions)) {
            throw new \LogicException('Hash options config should contain an entry named "salt"');
        }
        $oHash = new $sHashClass($aHashOptions['algo'], $aHashOptions['loops'], $aHashOptions['salt']);

        // Instanciate Encryptor
        // Check config
        if (!array_key_exists('class', $aEncryptConfig)) {
            throw new \LogicException('Encrypt config should contain an entry named "class"');
        }
        $sEncryptClass = $aEncryptConfig['class'];
        if (!array_key_exists('options', $aEncryptConfig)) {
            throw new \LogicException('Encrypt config should contain an entry named "options"');
        }
        $aEncryptOptions = $aEncryptConfig['options'];
        // Check encrypt options
        if (!array_key_exists('method', $aEncryptOptions)) {
            throw new \LogicException('Encrypt options config should contain an entry named "method"');
        }
        if (!array_key_exists('algo', $aEncryptOptions)) {
            throw new \LogicException('Encrypt options config should contain an entry named "algo"');
        }
        if (!array_key_exists('mode', $aEncryptOptions)) {
            throw new \LogicException('Encrypt options config should contain an entry named "mode"');
        }
        if (!array_key_exists('hash', $aEncryptOptions)) {
            throw new \LogicException('Encrypt options config should contain an entry named "hash"');
        }
        if (!array_key_exists('salt', $aEncryptOptions)) {
            throw new \LogicException('Encrypt options config should contain an entry named "salt"');
        }
        $oEncryptor = new $sEncryptClass($aEncryptOptions['method'], $aEncryptOptions);

        // Instanciate and return EncryptionService
        return new \EvilLib\Service\EncryptionService($oEncryptor, $oHash);
    }
}
