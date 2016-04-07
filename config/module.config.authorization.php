<?php

namespace EvilLib;

return array(
    'identity_provider' => '\EvilLib\Service\UserService',
    'role_providers' => array(
        'BjyAuthorize\Provider\Role\Config' => array(
            'guest' => array(),
            'user' => array('children' => array(
                    'admin' => array(),
                ),
            ),
        ),
    ),
    'guards' => array(
        'BjyAuthorize\Guard\Route' => array(
            array('route' => 'Home', 'roles' => array('guest')),
            // User
            array('route' => 'Home/LogOut', 'roles' => array('user')),
            array('route' => 'Home/LogIn', 'roles' => array('guest')),
            array('route' => 'Home/SignUp', 'roles' => array('guest')),
            array('route' => 'Home/SignUp/Ok', 'roles' => array('guest')),
            array('route' => 'Home/SignUp/Validate', 'roles' => array('guest')),
            array('route' => 'Home/EditUser', 'roles' => array('user')),
            // Console
            array('route' => 'CreateDatabaseSchema', 'roles' => array('guest')),
            array('route' => 'ValidateDatabaseSchema', 'roles' => array('guest')),
            array('route' => 'UpdateDatabaseSchema', 'roles' => array('guest')),
        ),
    ),
);
