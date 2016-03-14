<?php

namespace EvilLib;

return array(
    'driver' => array(
        'EvilLib_driver' => array(
            'class' => '\Doctrine\ORM\Mapping\Driver\AnnotationDriver',
            'cache' => 'array',
            'paths' => array(__DIR__ . '/../src/EvilLib/Entity'),
        ),
        'orm_default' => array(
            'drivers' => array(
                'EvilLib\Entity' => 'EvilLib_driver',
            ),
        ),
    ),
);
