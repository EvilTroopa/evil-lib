<?php

namespace EvilLib;

return array(
    'hash' => array(
        'class' => '\Application\Crypt\Hash',
        'options' => array(
            'algo' => 'sha256',
            'loops' => 500,
        ),
    ),
    'encrypt' => array(
        'class' => '\Application\Crypt\Encryptor',
        'options' => array(
            'method' => 'mcrypt',
            'algo' => 'aes',
            'mode' => 'cbc',
            'hash' => 'sha256',
        ),
    ),
);
