<?php

namespace EvilLib;

/**
 * Main config
 */
return array(
    'authentication' => include __DIR__ . '/module.config.authentication.php', // Authentication config
    'console' => include __DIR__ . '/module.config.console.php', // Console config
    'doctrine' => include __DIR__ . '/module.config.doctrine.php', // Controllers config
    'encryption' => include __DIR__ . '/module.config.encryption.php', // Encrpytion config
    'service_manager' => include __DIR__ . '/module.config.service-manager.php', // Service Manager config
    'zfctwig' => include __DIR__ . '/module.config.twig.php', // View manager config
);
