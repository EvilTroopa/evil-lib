<?php

namespace EvilLib;

return array(
    'connection' => array(
        'protocol' => 'smtp',
        'options' => array(
            'name' => 'localhost',
            'host' => 'smtp.myserver.com',
            'connection_class' => 'login',
            'port' => 1234,
            'connection_config' => array(
                'ssl' => 'tls',
                'username' => 'email@myserver.com',
                'password' => 'KTHXBYE',
            ),
        ),
    ),
    'default_values' => array(
        'from' => 'blah@myserver.com',
        'from_label' => null,
    ),
);
