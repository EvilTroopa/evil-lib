<?php

namespace EvilLib;

return array(
    'locale' => 'en_GB',
    'fallback_locale' => 'en_GB',
    'translation_file_patterns' => array(
        array(
            'type' => 'phparray',
            'base_dir' => __DIR__ . '/../language',
            'pattern' => '%s/User.php',
        ),
        array(
            'type' => 'phparray',
            'base_dir' => __DIR__ . '/../language',
            'pattern' => '%s/Base.php',
        ),
    ),
);
