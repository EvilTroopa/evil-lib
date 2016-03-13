<?php

namespace EvilLib;

return array(
    'environment_loader' => 'ZfcTwigLoaderChain',
    'environment_class' => 'Twig_Environment',
    'environment_options' => array(),
    'loader_chain' => array(
        'ZfcTwigLoaderTemplateMap',
        'ZfcTwigLoaderTemplatePathStack'
    ),
    'extensions' => array(
        'zfctwig' => 'ZfcTwigExtension',
        'I18nExtension' => '\Twig_Extensions_Extension_I18n',
//        'GeshiExtension' => '\Twig\Extension\GeshiExtension',
    ),
    'suffix' => 'twig',
    'enable_fallback_functions' => true,
    'disable_zf_model' => true,
    'helper_manager' => array(
        'configs' => array(
            'Zend\Navigation\View\HelperConfig',
        ),
        'invokables' => array(
            'Partial' => 'Zend\View\Helper\Partial',
            'PaginationControl' => 'Zend\View\Helper\PaginationControl',
        ),
    ),
);
