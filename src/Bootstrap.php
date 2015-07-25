<?php
namespace B2k\Apitude;

use B2k\Apitude\Provider\CommandServiceProvider;
use B2k\Apitude\Provider\DoctrineServiceProvider;
use Knp\Provider\ConsoleServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;

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
     * @return Application
     */
    public function createApplication()
    {
        $config = require(APP_PATH.'/config/local.config.php');

        $app = new Application($config);
        $app->register(new UrlGeneratorServiceProvider);
        $app->register(new DoctrineServiceProvider);
        $app->register(new CommandServiceProvider);

        return $app;
    }
}
