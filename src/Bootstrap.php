<?php
namespace B2k\Apitude;

class Bootstrap
{
    public function __construct()
    {
        if (!defined('APP_ENV')) {
            define('APP_ENV', 'development');
        }

        if (!defined('APP_PATH')) {
            throw new \RuntimeException('APP_PATH not set');
        }

        if (! is_dir(APP_PATH)) {
            throw new \RuntimeException('APP_PATH ('.APP_PATH.') is not a directory');
        }
    }
}
