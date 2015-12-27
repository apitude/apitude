<?php
namespace Apitude\Core\Provider;


use Apitude\Core\API\AnnotationDriver;
use Apitude\Core\API\Commands\GetCommand;
use Apitude\Core\API\EntityWriter;
use Apitude\Core\API\MetadataFactory;
use Apitude\Core\API\Writer\ArrayWriter;
use Apitude\Core\API\Writer\PropertyWriter;
use Doctrine\Common\Annotations\AnnotationReader;
use Silex\Application;

class APIServiceProvider extends AbstractServiceProvider
{
    protected $services = [
        EntityWriter::class,
        PropertyWriter::class,
        ArrayWriter::class,
    ];

    protected $commands = [
        GetCommand::class,
    ];

    public function register(Application $app)
    {
        parent::register($app);

        $app[MetadataFactory::class] = $app->share(function () {
            return new MetadataFactory(new AnnotationDriver(new AnnotationReader()));
        });
    }
}
