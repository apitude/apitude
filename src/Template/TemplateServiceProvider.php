<?php
namespace Apitude\Core\Template;

use Apitude\Core\Provider\AbstractServiceProvider;
use Apitude\Core\Utility\Arr;
use Handlebars\Handlebars;
use Handlebars\Loader\FilesystemLoader;
use Silex\Application;

class TemplateServiceProvider extends AbstractServiceProvider
{
    public function register(Application $app)
    {
        parent::register($app);
        $config = $app['config'];

        $app['handlebars'] = $app->share(function ($app) use ($config) {
            $templatePathConfigPath = 'template.handlebars.path';
            if (! Arr::path($config, $templatePathConfigPath)) {
                Arr::setPath(
                    $config,
                    $templatePathConfigPath,
                    APP_PATH . '/templates'
                );
            }

            return new Handlebars([
                'loader' => new FilesystemLoader(
                    Arr::path($config, $templatePathConfigPath),
                    [
                        'extension' => '.hbs',
                    ]
                ),
                'partials_loader' => new FilesystemLoader(
                    Arr::path($config, $templatePathConfigPath),
                    [
                        'prefix' => '_',
                    ]
                )
            ]);
        });

        $app['config'] = $config;
    }
}
