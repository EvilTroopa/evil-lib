<?php

return array(
    'display_not_found_reason' => true,
    'display_exceptions' => true,
    'doctype' => 'HTML5',
    'not_found_template' => 'error/404',
    'exception_template' => 'error/index',
//    'template_path_stack' => array(
//        __DIR__ . '/../view',
//    ),
    'template_map' => array(
        // User views
        'evillib/user/sign-up' => __DIR__ . '/../view/evillib/user/sign-up.twig',
        'evillib/user/sign-up-ok' => __DIR__ . '/../view/evillib/user/sign-up-ok.twig',
        'evillib/user/sign-up-validate' => __DIR__ . '/../view/evillib/user/sign-up-validate.twig',
        'evillib/user/log-in' => __DIR__ . '/../view/evillib/user/log-in.twig',
        // Emails
        'evillib/mail/sign-up-validate' => __DIR__ . '/../view/evillib/mail/sign-up-validate.twig',
    ),
    'strategies' => array(
        'twig' => 'ZfcTwigViewStrategy',
    ),
);
