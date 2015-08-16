<?php
use Apitude\Core\EntityServices\StampSubscriber;

return [
    // Add any extra configuration services to be registered here
    'configuration.services' => [
        // [class => config]
    ],

    // Begin DB/Doctrine config
    // Database connection options
    'db.options' => [
        'driver' => 'pdo_mysql',
        'dbname' => 'apitude',
        'user' => 'root',
        'password' => 'root',
        'host' => '127.0.0.1',
    ],
    'orm.options' => [
        'orm.proxies_dir' => APP_PATH.'/tmp/proxies',
        'orm.em.options' => [
            'mappings' => []
        ]
    ],
    'orm.subscribers' => [],
    // Note that Migrations is NOT inside src.  This is because it does not and should not
    // contain any application logic, and therefore is separate from the application.
    'migrations.directory' => APP_PATH.'/Migrations',
    // END db/doctrine config

    // service providers to register
    'service_providers' => [
        // add class names of other service providers you wish to register here
        // as keys, and configuration you wish to be passed to them as the value.
        // example : MyServiceProvider::class => ['configKey' => 37, ...]
    ],

    // commands to register
    'commands' => [
        // [class]
    ],
    'cache.driver' => 'redis', // or preferably xcache if you have it installed as it keeps metadata in-memory
    // You may include a cache.redis array including "host" and "port" if you do not wish to use the default redis
    // configuration
    'redis' => [
        'host' => 'localhost',
        'port' => 6379
    ]
];
