<?php
namespace Apitude\Core\Provider;

use Qless\Client;
use Silex\Application;

class QlessServiceProvider extends AbstractServiceProvider
{
    public function register(Application $app)
    {
        parent::register($app);

        $app['qless.client'] = $app->share(function() use ($app) {
            $config = $app['config'];
            return new Client($config['qless']['host'], $config['qless']['port']);
        });
    }
}
