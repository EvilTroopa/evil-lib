<?php

namespace EvilLib;

/**
 * Main config
 */
return array(
    'assets_bundle' => include __DIR__ . '/module.config.assets-bundle.php', // Asset Bundle config
    'authentication' => include __DIR__ . '/module.config.authentication.php', // Authentication config
    'bjyauthorize' => include __DIR__ . '/module.config.authorization.php', // Authorization config
    'console' => include __DIR__ . '/module.config.console.php', // Console config
    'controllers' => include __DIR__ . '/module.config.controllers.php', // Controllers config
    'doctrine' => include __DIR__ . '/module.config.doctrine.php', // Controllers config
    'encryption' => include __DIR__ . '/module.config.encryption.php', // Encrpytion config
    'mail' => include __DIR__ . '/module.config.mail.php', // Mail config
    'recaptcha' => include __DIR__ . '/module.config.recaptcha.php', // ReCaptcha config
    'router' => include __DIR__ . '/module.config.router.php', // Router config
    'service_manager' => include __DIR__ . '/module.config.service-manager.php', // Service Manager config
    'session' => include __DIR__ . '/module.config.session.php', // Session config
    'translator' => include __DIR__ . '/module.config.translator.php', // Translation config
    'view_manager' => include __DIR__ . '/module.config.view-manager.php', // View manager config
    'zfctwig' => include __DIR__ . '/module.config.twig.php', // View manager config
);
