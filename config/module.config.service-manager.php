<?php

namespace EvilLib;

return array(
    'aliases' => array(
        'Zend\Authentication\AuthenticationService' => 'AuthenticationService',
    ),
    'abstract_factories' => array(
        '\Zend\Cache\Service\StorageCacheAbstractServiceFactory',
        '\Zend\Log\LoggerAbstractServiceFactory',
        '\EvilLib\Factory\RepositoryAbstractFactory',
        '\EvilLib\Factory\ServiceAbstractFactory',
        '\EvilLib\Factory\ControllerAbstractFactory',
    ),
    'factories' => array(
        'Encryptor' => '\EvilLib\Factory\EncryptionServiceFactory',
        'translator' => '\Zend\Mvc\Service\TranslatorServiceFactory',
        'AuthenticationService' => '\EvilLib\Authentication\AuthenticationServiceFactory',
        'SignUpForm' => '\EvilLib\Factory\Form\SignUpFormFactory',
    ),
    'services' => array(
        'UserService' => '\EvilLib\Service\UserService',
    ),
);
