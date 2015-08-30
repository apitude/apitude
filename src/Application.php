<?php
namespace Apitude\Core;

use Apitude\Core\Provider\ContainerAwareInterface;
use Apitude\Core\Provider\ShutdownInterface;
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

    /**
     * @var array
     */
    protected $initializers = [];

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

        $this->addInitializer(ContainerAwareInterface::class, function(ContainerAwareInterface $service, $app) {
            $service->setContainer($app);
        });

        if (array_key_exists('service_providers', $config)) {
            $this->registerServiceProviders($config['service_providers']);
        }

        if (array_key_exists('configuration.services', $config)) {
            $this->addConfiguredServices($config['configuration.services']);
        }
    }

    /**
     * Override Pimple's offsetGet to add support for initializers
     *
     * @param  string $id The unique identifier for the parameter or object
     * @return mixed      The value of the parameter or an object
     */
    public function offsetGet($id)
    {
        $value = parent::offsetGet($id);
        if (is_object($value)) {
            $this->initialize($value);
        }
        return $value;
    }

    /**
     * Initialize an object
     *
     * @param  mixed $object Object to be initialized
     * @return mixed
     */
    public function initialize($object)
    {
        foreach ($this->initializers as $interface => $initializer) {
            if ($object instanceof $interface) {
                $initializer($object, $this);
            }
        }
        return $object;
    }

    /**
     * Add an initializer
     *
     * @param  string   $interface Interface to trigger initialization
     * @param  callable $callable  function(service, application)
     * @return self
     */
    public function addInitializer($interface, callable $callable)
    {
        $this->initializers[$interface] = $callable;
        return $this;
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
        if ($instance instanceof ShutdownInterface) {
            $this->shutdownServices [] = $instance;
        }

        return $instance;
    }

    public function boot()
    {
        if (!$this->booted) {
            parent::boot();
            if ($this instanceof \Knp\Console\Application) {
                return;
            }
            if (php_sapi_name() === 'cli' && isset($this['config']['commands'])) {
                $this->registerCommands($this['config']['commands']);
                $this->registerCommands($this['base_commands']);
            }
        }
    }

    private function registerCommands(array $commands)
    {
        /** @var \Knp\Console\Application $console */
        $console = $this['console'];
        foreach ($commands as $class)
        {
            $command = new $class;
            $console->add($command);
            foreach ($this['console.configure'] as $callback) {
                $callback($command);
            }
        }
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
