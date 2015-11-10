<?php
namespace Apitude\Core;

use Apitude\Core\Email\EmailServiceProvider;
use Apitude\Core\Provider\APIServiceProvider;
use Apitude\Core\Provider\CacheServiceProvider;
use Apitude\Core\Provider\CommandServiceProvider;
use Apitude\Core\Provider\ContainerAwareInterface;
use Apitude\Core\Provider\ControllerResolver;
use Apitude\Core\Provider\DoctrineServiceProvider;
use Apitude\Core\Provider\QlessServiceProvider;
use Apitude\Core\Provider\ShutdownInterface;
use Asm89\Stack\Cors;
use Apitude\Core\Provider\RedisServiceProvider;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
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

        $this->register(new CommandServiceProvider);

        if (array_key_exists('service_providers', $config)) {
            $this->registerServiceProviders($config['service_providers']);
        }

        if (array_key_exists('configuration.services', $config)) {
            $this->addConfiguredServices($config['configuration.services']);
        }

        $this->register(
            new MonologServiceProvider(),
            isset($config['monolog']) ? $config['monolog'] : ['monolog.logfile' => APP_PATH.'/app.log']
        );

        $this->register(new UrlGeneratorServiceProvider);
        $this->register(new CacheServiceProvider);
        $this->register(new DoctrineServiceProvider);
        $this->register(new APIServiceProvider);
        $this->register(new QlessServiceProvider);
        $this->register(new EmailServiceProvider);
        $this->register(new RedisServiceProvider);

        $app = $this;
        $this['resolver'] = $this->share(function () use ($app) {
            return new ControllerResolver($app, $app['logger']);
        });
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
                $this->register(new $config([]));
            } else {
                $this->register(new $class(), $config ?: []);
            }
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
                /** @var \Monolog\Logger $logger */
                $logger = $this['logger'];
                $handler = new StreamHandler('php://stdout');
                $handler->setFormatter(new LineFormatter());
                $logger->pushHandler($handler);
            }
        }
    }

    private function registerCommands(array $commands)
    {
        /** @var \Knp\Console\Application $console */
        $console = $this['console'];
        foreach ($commands as $class)
        {
            if (is_object($class)) {
                $command = $class;
            } else {
                $command = new $class;
            }
            $console->add($command);
            foreach ($this['console.configure'] as $callback) {
                $callback($command);
            }
        }
    }

    public function run(Request $request = null)
    {
        if (null === $request) {
            $request = Request::createFromGlobals();
        }

        $corsConfig = isset($config['cors']) ? $config['cors'] : [
            'allowedHeaders'      => ['*'],
            'allowedMethods'      => ['*'],
            'allowedOrigins'      => ['*'],
            'exposedHeaders'      => false,
            'maxAge'              => false,
            'supportsCredentials' => false,
        ];

        $cors = new Cors($this, $corsConfig);

        $response = $cors->handle($request);
        $response->send();

        $this->terminate($request, $response);
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
