<?php
if (! file_exists(__DIR__.'/vendor/autoload.php')) {
    throw new \RuntimeException('vendor/autoload not found.  Please run composer install');
}
require_once __DIR__.'/vendor/autoload.php';

if (!defined('APP_ENV')) {
    if (getenv('APP_ENV')) {
        define('APP_ENV', getenv('APP_ENV'));
    } else {
        define('APP_ENV', 'development');
    }
}

if (!defined('APP_PATH')) {
    define('APP_PATH', realpath(__DIR__));
}

$bs = new \Apitude\Core\Bootstrap();
$app = $bs->createApplication();

// add extra service providers here

$app->boot();
return $app;
