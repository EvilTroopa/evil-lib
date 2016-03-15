<?php

namespace EvilLib;

return array(
    'abstract_factories' => array(
        '\Zend\Cache\Service\StorageCacheAbstractServiceFactory',
        '\Zend\Log\LoggerAbstractServiceFactory',
        '\EvilLib\Factory\RepositoryAbstractFactory',
        '\EvilLib\Factory\ServiceAbstractFactory',
    ),
    'factories' => array(
        'Encryptor' => '\EvilLib\Factory\EncryptionServiceFactory',
        'translator' => '\Zend\Mvc\Service\TranslatorServiceFactory',
        'AuthenticationService' => '\EvilLib\Authentication\AuthenticationServiceFactory',
    ),
    'services' => array(
        'ZfcTwigViewStrategy' => '\ZfcTwig\View\RenderingStrategy',
//        'UserService' => '\EvilLib\Service\UserService',
    ),
);
