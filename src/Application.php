<?php
namespace B2k\Apitude;

use B2k\Apitude\Provider\ContainerAwareInterface;
use B2k\Apitude\Provider\ShutdownInterface;
use Symfony\Component\HttpFoundation\Request;

class Application extends \Silex\Application
{
    const CONFIG_KEY = 'config';
    const DEBUG_KEY  = 'debug';
    const ENV_DEVELOPMENT = 'development';
    const ENV_PRODUCTION  = 'production';

    /**
     * @var ShutdownInterface[]
     */
    protected $shutdownServices = [];

    public function __construct($config, $values = [])
    {
        if (empty($values)) {
            $values = [
                self::DEBUG_KEY => (APP_ENV !== self::ENV_PRODUCTION)
            ];
        } else {
            $values = array_merge($values, [
                self::DEBUG_KEY => (APP_ENV !== self::ENV_PRODUCTION)
            ]);
        }

        parent::__construct($values);

        if (!defined('APP_ENV')) {
            throw new \RuntimeException('APP_ENV is not defined; check local.config.php');
        }

        $this[self::CONFIG_KEY] = $config;
        $this['cache_dir'] = APP_PATH . '/tmp';

        if (array_key_exists('service_providers', $config)) {
            $this->registerServiceProviders($config['service_providers']);
        }

        if (array_key_exists('configuration.services', $config)) {
            $this->addConfiguredServices($config['configuration.services']);
        }
    }

    private function registerServiceProviders(array $providers)
    {
        foreach ($providers as $class => $config)
        {
            if (is_numeric($class)) {
                throw new \RuntimeException('Bad service provider configuration');
            }
            $this->register(new $class(), $config ?: []);
        }
    }

    private function addConfiguredServices($services)
    {
        if (!is_array($services)) {
            return;
        }

        foreach ($services as $service => $val) {
            if (isset($this[$service])) {
                unset($this[$service]);
            }
            $this[$service] = function () use ($val) {
                return $this->createInvokable($val);
            };
        }
    }

    private function createInvokable($service)
    {
        if (strpos($service, '::') !== false) {
            $instance = call_user_func($service, $this);
        } else {
            $instance = new $service();
        }
        if ($instance instanceof ContainerAwareInterface) {
            $instance->setContainer($this);
        }
        if ($instance instanceof ShutdownInterface) {
            $this->shutdownServices [] = $instance;
        }

        return $instance;
    }

    public function run(Request $request = null)
    {
        parent::run($request);
        $this->shutdown();
    }

    /**
     * Called after request is finished for extra service functionality
     */
    public function shutdown()
    {
        foreach ($this->shutdownServices as $service) {
            $service->shutdown();
        }
    }

    public function runConsole()
    {
        $this['console']->run();
        $this->shutdown();
    }
}
