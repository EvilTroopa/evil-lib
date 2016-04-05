<?php

namespace EvilLib;

return array(
    'router' => array(
        'routes' => array(
            'CreateDatabaseSchema' => array(
                'options' => array(
                    'route' => 'create-database-schema',
                    'defaults' => array(
                        'controller' => 'EvilLib\Controller\Console',
                        'action' => 'createDatabaseSchema',
                    ),
                ),
            ),
            'ValidateDatabaseSchema' => array(
                'options' => array(
                    'route' => 'validate-database-schema',
                    'defaults' => array(
                        'controller' => 'EvilLib\Controller\Console',
                        'action' => 'validateDatabaseSchema',
                    ),
                ),
            ),
            'UpdateDatabaseSchema' => array(
                'options' => array(
                    'route' => 'update-database-schema',
                    'defaults' => array(
                        'controller' => 'EvilLib\Controller\Console',
                        'action' => 'updateDatabaseSchema',
                    ),
                ),
            ),
        ),
    ),
);
