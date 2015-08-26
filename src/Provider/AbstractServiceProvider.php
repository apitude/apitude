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
        foreach ($this->services as $key => $class) {
            if (is_numeric($key)) {
                $key = $class;
            }
            $app[$key] = $app->share(function() use ($class) {
                return new $class();
            });
        }

        if (!empty($this->doctrineEventSubscribers)) {
            $config = $app['config'];
            foreach ($this->doctrineEventSubscribers as $class) {
                $config['orm.subscribers'][] = $class;
            }
        }

        if (!empty($this->entityFolders)) {
            if (!isset($config)) {
                $config = $app['config'];
            }
            foreach ($this->entityFolders as $namespace => $path) {
                $config['orm.options']['orm.em.options']['mappings'][] = [
                    'type' => 'annotation',
                    'namespace' => $namespace,
                    'path' => $path,
                    'use_simple_annotation_reader' => false,
                ];
            }
        }

        if (isset($config)) {
            $app['config'] = $config;
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
