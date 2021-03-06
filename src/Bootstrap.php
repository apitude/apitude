<?php
namespace Apitude\Core;

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

    /**
     * @param null|array $config
     * @return Application
     */
    public function createApplication($config = null)
    {
        if (!$config) {
            $config = require(APP_PATH.'/config/local.config.php');
        }

        $app = new Application($config);

        return $app;
    }
}
