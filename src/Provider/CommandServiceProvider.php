<?php
namespace B2k\Apitude\Provider;


use B2k\Apitude\Commands\Entities\ListCommand;
use B2k\Apitude\Commands\Entities\TypesCommand;
use Knp\Provider\ConsoleServiceProvider;
use Silex\Application;
use Silex\ServiceProviderInterface;

class CommandServiceProvider implements ServiceProviderInterface
{

    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     * @param Application $app
     */
    public function register(Application $app)
    {
        if (php_sapi_name() === 'cli') {
            $app->register(new ConsoleServiceProvider, [
                'console.name' => 'Apitude',
                'console.version' => '1.0.0',
                'console.project_directory' => APP_PATH,
            ]);
            $app['base_commands'] = $app->share(function() {
                return [
                    TypesCommand::class,
                    ListCommand::class,
                ];
            });
        }
    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registered
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     * @param Application $app
     */
    public function boot(Application $app)
    {
        // nope.
    }
}
