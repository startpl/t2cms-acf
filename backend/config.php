<?php
return [
    'controllerMap' => [
        'elfinder' => [
            'class' => 'mihaildev\elfinder\Controller',
            'disabledCommands' => ['netmount'],
            'access' => ['@'],
            'roots' => [
                [
                    'baseUrl' => '',
                    'basePath' => '@www',
                    'path' => 'uploads',
                    'name' => 'Files'
                ],
                [
                    'path' => 'uploads/images',
                    'name' => 'Images'
                ],
            ],
        ],
    ],
];