<?php

return [
    // Add any extra configuration services to be registered here
    'configuration.services' => [
        // [class => config]
    ],

    // Begin DB/Doctrine config
    // Database connection options
    'db.options' => [
        'driver_class' => \Apitude\Core\DBAL\MysqlPlatform::class,
        'dbname' => 'apitude',
        'user' => 'root',
        'password' => 'root',
        'host' => '127.0.0.1',
        'charset' => 'utf8mb4', // to allow for unicode, remember to specify ascii collation on fields to be indexed!
    ],
    'orm.options' => [
        'orm.proxies_dir' => APP_PATH.'/tmp/proxies',
        'orm.em.options' => [
            'mappings' => []
        ]
    ],
    // If you are using any of the gedmo extensions, register the appropriate listener classes below
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

    // commands to register (but you should do this from your service providers
    'commands' => [
        // [class]
    ],
    'cache.driver' => 'redis', // or preferably xcache if you have it installed as it keeps metadata in-memory
    // You may include a cache.redis array including "host" and "port" if you do not wish to use the default redis
    // configuration
    'redis' => [
        'host' => '127.0.0.1',
        'port' => 6379
    ],

    'qless' => [
        'host' => '127.0.0.1',
        'port' => 6379
    ],

    'email' => [
        'sender' => \Apitude\Core\Email\Service\SimpleSender::class,
    ],

    // see http://silex.sensiolabs.org/doc/providers/monolog.html
    'monolog' => [
        'name' => 'MyAppName',
        'monolog.logfile' => APP_PATH.'/logs/app.log',
    ]
];
