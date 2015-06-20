<?php
if (! file_exists('./vendor/autoload.php')) {
    throw new \RuntimeException('vendor/autoload not found.  Please run composer install');
}
require_once './vendor/autoload.php';

if (!defined('APP_ENV')) {
    define('APP_ENV', 'development');
}

if (!defined('APP_PATH')) {
    define('APP_PATH', realpath(__DIR__));
}

$bs = new \B2k\Apitude\Bootstrap();
$app = $bs->createApplication();

// add extra service providers here

$app->boot();
return $app;