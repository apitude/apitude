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
    protected $entityFolders = [];

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

        if (!empty($this->entityFolders)) {
            $mappings =& $app['config']['orm.options']['orm.em.options']['mappings'];

            foreach ($this->entityFolders as $namespace => $path) {
                $mappings[] = [
                    'type' => 'annotation',
                    'namespace' => $namespace,
                    'path' => $path,
                    'use_simple_annotation_reader' => false,
                ];
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
