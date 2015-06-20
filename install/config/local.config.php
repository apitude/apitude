<?php
return [
    // Database connection options
    'db.options' => [
        'driver' => 'pdo_mysql',
        'dbname' => 'apitude',
        'user' => 'root',
        'password' => 'root',
        'host' => '127.0.0.1',
    ],
    'doctrine.options' => [
        'orm.proxies_dir' => APP_PATH.'/tmp/proxies',
        'orm.em.options' => [
            'mappings' => [
                [
                    'type' => 'annotation',
                    'namespace' => 'YOURAPPLICATION\Entities',
                    'path' => APP_PATH.'/src/Entities',
                    'use_simple_annotation_reader' => false,
                ]
            ]
        ]
    ],
    // Note that Migrations is NOT inside src.  This is because it does not and should not
    // contain any application logic, and therefore is separate from the application.
    'migrations.directory' => APP_PATH.'/Migrations',

    'service_providers' => [
        // add class names of other service providers you wish to register here
        // as keys, and configuration you wish to be passed to them as the value.
        // example : MyServiceProvider::class => ['configKey' => 37, ...]
    ]
];
