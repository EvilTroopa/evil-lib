<?php

namespace EvilLib;

return array(
    'abstract_factories' => array(
        '\Zend\Cache\Service\StorageCacheAbstractServiceFactory',
        '\Zend\Log\LoggerAbstractServiceFactory',
        '\Application\Factory\RepositoryAbstractFactory',
    ),
    'factories' => array(
        'translator' => '\Zend\Mvc\Service\TranslatorServiceFactory',
        'Encryptor' => '\Application\Factory\EncryptionServiceFactory',
    ),
    'services' => array(
        'ZfcTwigViewStrategy' => '\ZfcTwig\View\RenderingStrategy',
    ),
);
