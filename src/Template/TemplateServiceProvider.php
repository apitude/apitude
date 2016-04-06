<?php
namespace Apitude\Core\Template;

use Apitude\Core\Provider\AbstractServiceProvider;
use Handlebars\Handlebars;
use Handlebars\Loader\FilesystemLoader;

class TemplateServiceProvider extends AbstractServiceProvider
{
    public function register(Application $app)
    {
        parent::register($app);
        $config = $app['config'];

        $templatePathConfigPath = 'template.handlebars.path';
        if (! Arr::path($config, $templatePathConfigPath)) {
            Arr::setPath(
                $config,
                $templatePathConfigPath,
                APP_PATH . '/templates'
            );
        }
        $app['handlebars'] = $app->share(function ($app) {
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
