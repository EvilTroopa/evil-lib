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
//        '\EvilLib\Factory\ServiceAbstractFactory',
        '\EvilLib\Factory\ControllerAbstractFactory',
    ),
    'factories' => array(
        'Encryptor' => '\EvilLib\Factory\EncryptionServiceFactory',
        'translator' => '\Zend\Mvc\Service\TranslatorServiceFactory',
        'AuthenticationService' => '\EvilLib\Authentication\AuthenticationServiceFactory',
        'Session' => '\EvilLib\Factory\SessionFactory',
        'MailService' => '\EvilLib\Factory\MailServiceFactory',
        // Forms
        'SignUpForm' => '\EvilLib\Factory\Form\SignUpFormFactory',
        'LostPasswordForm' => '\EvilLib\Factory\Form\LostPasswordFormFactory',
        'EditUserForm' => '\EvilLib\Factory\Form\EditUserFormFactory',
    ),
    'invokables' => array(
        'UserService' => '\EvilLib\Service\UserService',
    ),
);
