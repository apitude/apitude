<?php
namespace Apitude\Provider;


use Apitude\API\AnnotationDriver;
use Apitude\API\Commands\GetCommand;
use Apitude\API\EntityWriter;
use Apitude\API\MetadataFactory;
use Doctrine\Common\Annotations\AnnotationReader;
use Silex\Application;

class APIServiceProvider extends AbstractServiceProvider
{
    protected $services = [
        EntityWriter::class,
    ];

    protected $commands = [
        GetCommand::class,
    ];

    public function register(Application $app)
    {
        parent::register($app);

        $app[MetadataFactory::class] = $app->share(function () use ($app) {
            return new MetadataFactory(new AnnotationDriver(new AnnotationReader()));
        });
    }
}
