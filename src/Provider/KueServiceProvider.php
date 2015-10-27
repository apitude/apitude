<?php
namespace Apitude\Core\Provider;

use Kue\Command\WorkCommand;
use Kue\RedisQueue;
use Silex\Application;

class KueServiceProvider extends AbstractServiceProvider
{
    protected $commands = [
    ];

    protected $services = [];

    public function register(Application $app)
    {
        parent::register($app);

        $app['kue.queue'] = $app->share(function() use($app) {
            return new RedisQueue($app['redis']);
        });
    }

    public function boot(Application $app) {
        if (php_sapi_name() === 'cli') {
            $config = $app['config'];
            $config['commands'][] = new WorkCommand($app['kue.queue']);
            $app['config'] = $config;
        }
    }
}
