<?php

namespace EvilLib;

return array(
    'configuration' => array(
        'orm_default' => array(
            'proxy_dir' => __DIR__ . '/../../../data/cache/DoctrineOrmProxies',
        ),
    ),
    'driver' => array(
        __NAMESPACE__ . '_driver' => array(
            'class' => '\Doctrine\ORM\Mapping\Driver\AnnotationDriver',
            'cache' => 'array',
            'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'),
        ),
        'orm_default' => array(
            'drivers' => array(
                __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
            ),
        ),
    ),
);
