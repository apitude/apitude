<?php
namespace Apitude\Core\Provider;


use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\RequestMatcher;

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
     * @param Application|\Apitude\Core\Application $app
     */
    public function register(Application $app)
    {
        foreach ($this->services as $key => $class) {
            if (is_numeric($key)) {
                $key = $class;
            }
            $app[$key] = $app->share(function() use ($class, $app) {
                $result = new $class();
                $app->initialize($result);
                return $result;
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

    /**
     * Add a firewall record
     * @param Application $app
     * @param string|RequestMatcher $pattern
     * @param string $authType (oauth, anonymous, oauth-optional, etc)
     */
    protected function addFirewall(Application $app, $pattern, $authType)
    {
        $firewalls = $app['security.firewalls'];
        $key = is_object($pattern) ? spl_object_hash($pattern) : $pattern;
        $firewalls[$key] =  [
            'pattern' => $pattern,
            $authType => true,
        ];

        $app['security.firewalls'] = $firewalls;
    }

    /**
     * Add access rule to limit specific paths by role
     * @param Application $app
     * @param string $pattern
     * @param string|array $roles
     */
    protected function addAccessRule(Application $app, $pattern, $roles) {
        $security = $app['security.access_rules'];
        $key = is_object($pattern) ? spl_object_hash($pattern) : $pattern;
        $security[$key] = [
            $pattern,
            $roles
        ];

        $app['security.access_rules'] = $security;
    }
}
