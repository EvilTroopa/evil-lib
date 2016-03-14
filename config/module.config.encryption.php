<?php

namespace EvilLib;

return array(
    'hash' => array(
        'class' => '\EvilLib\Crypt\Hash',
        'options' => array(
            'algo' => 'sha256',
            'loops' => 500,
        ),
    ),
    'encrypt' => array(
        'class' => '\EvilLib\Crypt\Encryptor',
        'options' => array(
            'method' => 'mcrypt',
            'algo' => 'aes',
            'mode' => 'cbc',
            'hash' => 'sha256',
        ),
    ),
);
