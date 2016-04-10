<?php

return array(
    'routes' => array(
        'Home' => array(
            'type' => 'Zend\Mvc\Router\Http\Segment',
            'options' => array(
                'route' => '/',
                'defaults' => array(
                    'controller' => 'EvilLib\Controller\User',
                    'action' => 'index',
                ),
            ),
            'may_terminate' => true,
            'child_routes' => array(
                'SignUp' => array(
                    'type' => 'Zend\Mvc\Router\Http\Segment',
                    'options' => array(
                        'route' => 'sign-up[/]',
                        'defaults' => array(
                            'controller' => 'EvilLib\Controller\User',
                            'action' => 'signUp',
                        ),
                    ),
                    'may_terminate' => true,
                    'child_routes' => array(
                        'Ok' => array(
                            'type' => 'Zend\Mvc\Router\Http\Segment',
                            'options' => array(
                                'route' => 'ok[/]',
                                'defaults' => array(
                                    'action' => 'signUpOk',
                                ),
                            ),
                        ),
                        'Validate' => array(
                            'type' => 'Zend\Mvc\Router\Http\Segment',
                            'options' => array(
                                'route' => 'validate/:hash[/]',
                                'defaults' => array(
                                    'action' => 'signUpValidate',
                                ),
                            ),
                        ),
                    ),
                ),
                'LogIn' => array(
                    'type' => 'Zend\Mvc\Router\Http\Segment',
                    'options' => array(
                        'route' => 'log-in[/]',
                        'defaults' => array(
                            'controller' => 'EvilLib\Controller\User',
                            'action' => 'logIn',
                        ),
                    ),
                ),
                'LogOut' => array(
                    'type' => 'Zend\Mvc\Router\Http\Segment',
                    'options' => array(
                        'route' => 'log-out[/]',
                        'defaults' => array(
                            'controller' => 'EvilLib\Controller\User',
                            'action' => 'logOut',
                        ),
                    ),
                ),
                'LostPassword' => array(
                    'type' => 'Zend\Mvc\Router\Http\Segment',
                    'options' => array(
                        'route' => 'lost-password[/]',
                        'defaults' => array(
                            'controller' => 'EvilLib\Controller\User',
                            'action' => 'lostPassword',
                        ),
                    ),
                ),
                'RenewPassword' => array(
                    'type' => 'Zend\Mvc\Router\Http\Segment',
                    'options' => array(
                        'route' => 'renew-password/:hash[/]',
                        'defaults' => array(
                            'controller' => 'EvilLib\Controller\User',
                            'action' => 'renewPassword',
                        ),
                    ),
                ),
                'RenewPasswordOk' => array(
                    'type' => 'Zend\Mvc\Router\Http\Segment',
                    'options' => array(
                        'route' => 'renew-password-ok[/]',
                        'defaults' => array(
                            'controller' => 'EvilLib\Controller\User',
                            'action' => 'renewPasswordOk',
                        ),
                    ),
                ),
                'EditUser' => array(
                    'type' => 'Zend\Mvc\Router\Http\Segment',
                    'options' => array(
                        'route' => 'edit-user[/]',
                        'defaults' => array(
                            'controller' => 'EvilLib\Controller\User',
                            'action' => 'editUser',
                        ),
                    ),
                ),
            ),
        ),
    ),
);
