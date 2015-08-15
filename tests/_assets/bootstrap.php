<?php
if (!defined('APP_ENV')) {
    define('APP_ENV', 'development');
}

if (!defined('APP_PATH')) {
    define('APP_PATH', realpath(__DIR__));
}

require_once realpath(__DIR__.'/../../vendor').'/autoload.php';
// annotation classes
require_once realpath(__DIR__.'/../../src/Annotations').'/APIAnnotations.php';

$bs = new \Apitude\Core\Bootstrap();
$app = $bs->createApplication();

// add extra service providers here

$app->boot();
return $app;