<?php

namespace EvilLib;

return array(
    'abstract_factories' => array(
        '\Zend\Cache\Service\StorageCacheAbstractServiceFactory',
        '\Zend\Log\LoggerAbstractServiceFactory',
        '\EvilLib\Factory\RepositoryAbstractFactory',
    ),
    'factories' => array(
        'Encryptor' => '\EvilLib\Factory\EncryptionServiceFactory',
        'translator' => '\Zend\Mvc\Service\TranslatorServiceFactory',
    ),
    'services' => array(
        'ZfcTwigViewStrategy' => '\ZfcTwig\View\RenderingStrategy',
    ),
);
