<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Tinyurl\Controller\Tinyurl' => 'Tinyurl\Controller\TinyurlController',
        ),
    ),
	
	'router' => array(
        'routes' => array(
            'url' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/url[/:action][/:tiny]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'tiny'     => '[a-zA-Z0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Tinyurl\Controller\Tinyurl',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
 
    'view_manager' => array(
        'template_path_stack' => array(
            'tinyurl' => __DIR__ . '/../view',
        ),
    ),
);