<?php
namespace Apitude\Core\Provider;


use Apitude\Core\EntityServices\StampSubscriber;
use Apitude\Core\ORM\SimpleHydrator;
use Dbtlr\MigrationProvider\Provider\MigrationServiceProvider;
use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\EventManager;
use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManagerInterface;
use Gedmo\DoctrineExtensions;
use Silex\Application;
use Silex\ServiceProviderInterface;

class DoctrineServiceProvider extends AbstractServiceProvider implements ServiceProviderInterface
{
    public function __construct()
    {
        $this->entityFolders['Apitude\Core\Entities'] = realpath(__DIR__.'/../Entities');
        $this->doctrineEventSubscribers[] = StampSubscriber::class;
    }

    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     * @param Application $app
     */
    public function register(Application $app)
    {
        parent::register($app);

        $app->register(
            new \Silex\Provider\DoctrineServiceProvider(),
            ['db.options' => $app['config']['db.options']]
        );
        $app->register(
            new DoctrineOrmServiceProvider(),
            $app['config']['orm.options']
        );

        if (getenv('MIGRATION_COMMANDS')) {
            $app->register(new MigrationServiceProvider(), [
                'db.migrations.path' =>$app['config']['migrations.directory'],
            ]);
        }

        $app['orm.em'] = $app->extend('orm.em', function(EntityManagerInterface $em) use($app) {
            if (file_exists(APP_PATH.'/vendor/apitude/apitude/src/Annotations/APIAnnotations.php')) {
                AnnotationRegistry::registerFile(APP_PATH.'/vendor/apitude/apitude/src/Annotations/APIAnnotations.php');
            }
            /** @var Configuration $config */
            $config = $em->getConfiguration();
            $config->setMetadataCacheImpl($app['cache']);
            $config->addCustomHydrationMode('simple', SimpleHydrator::class);

            /** @var MappingDriverChain $driver */
            $driver = $config->getMetadataDriverImpl();

            // gedmo initialization
            $reader = new AnnotationReader();
            $cache = new CachedReader($reader, $app['cache']);
            DoctrineExtensions::registerAbstractMappingIntoDriverChainORM(
                $driver,
                $cache
            );

            return $em;
        });
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
        $config = $app['config'];
        if (isset($config['orm.subscribers'])) {
            $app->extend('db.event_manager', function($eventMgr) use($app, $config) {
                /** @var EventManager $eventMgr */
                foreach ($config['orm.subscribers'] as $class) {
                    if (isset($app[$class])) {
                        $eventMgr->addEventSubscriber($app[$class]);
                    } else {
                        $eventMgr->addEventSubscriber(new $class());
                    }
                }
                return $eventMgr;
            });
        }
    }
}
