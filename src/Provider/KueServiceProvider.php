<?php
namespace Apitude\Core\Provider;

use Apitude\Core\Kue\RedisQueue;
use Kue\Command\WorkCommand;
use Silex\Application;

class KueServiceProvider extends AbstractServiceProvider
{
    protected $commands = [
    ];

    protected $services = [
        'kue.queue' => RedisQueue::class
    ];

    public function boot(Application $app) {
        if (php_sapi_name() === 'cli') {
            $config = $app['config'];
            $config['commands'][] = new WorkCommand($app['kue.queue']);
            $app['config'] = $config;
        }
    }
}
