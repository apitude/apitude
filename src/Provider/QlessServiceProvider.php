<?php
namespace Apitude\Core\Provider;

use Apitude\Core\Qless\Commands\TestJob;
use Apitude\Core\Qless\TestaJob;
use Qless\Client;
use Silex\Application;

class QlessServiceProvider extends AbstractServiceProvider
{
    protected $commands = [
        TestJob::class,
    ];

    protected $services = [
        TestaJob::class,
    ];

    public function register(Application $app)
    {
        parent::register($app);

        $app['qless.client'] = $app->share(function() use ($app) {
            $config = $app['config'];
            return new Client($config['qless']['host'], $config['qless']['port']);
        });
    }
}
