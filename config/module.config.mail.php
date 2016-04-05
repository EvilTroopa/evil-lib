<?php

namespace EvilLib;

return array(
    'protocol' => 'smtp',
    'options' => array(
        'name' => 'localhost',
        'host' => 'smtp.myserver.com',
        'connection_class' => 'login',
        'port' => 1234,
        'connection_config' => array(
            'auth' => 'login',
            'ssl' => 'tls',
            'user' => 'email@myserver.com',
            'password' => 'KTHXBYE',
        ),
    ),
);
