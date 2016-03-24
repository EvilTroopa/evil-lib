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
                        'Validate' => array(
                            'type' => 'Zend\Mvc\Router\Http\Segment',
                            'options' => array(
                                'route' => 'validate/:hash[/]',
                                'defaults' => array(
                                    'action' => 'validate',
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
