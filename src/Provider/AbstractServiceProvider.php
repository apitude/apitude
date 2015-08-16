<?php
namespace Apitude\Core\Provider;


use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * Class AbstractServiceProvider
 * @package Apitude\Core\Provider
 */
abstract class AbstractServiceProvider implements ServiceProviderInterface
{
    protected $services = [];
    protected $commands = [];
    protected $doctrineEventSubscribers = [];

    /**
     * Automatically registers all service classes in $this->services array
     * {@inheritdoc}
     * @param Application $app
     */
    public function register(Application $app)
    {
        foreach ($this->services as $class) {
            $app[$class] = $app->share(function() use ($class) {
                return new $class();
            });
        }

        if (!empty($this->doctrineEventSubscribers)) {
            $subscribers = &$app['config']['orm.subscribers'];
            foreach ($this->doctrineEventSubscribers as $class) {
                $subscribers[] = $class;
            }
        }

        if (php_sapi_name() === 'cli' && !empty($this->commands)) {
            $app['base_commands'] = $app->extend('base_commands', function(array $commands) {
                return array_merge($commands, $this->commands);
            });
        }
    }

    /**
     * {@inheritdoc}
     * @param Application $app
     */
    public function boot(Application $app)
    {
        // nope.
    }
}
