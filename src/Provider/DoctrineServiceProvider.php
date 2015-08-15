<?php
namespace Apitude\Core\Provider;


use Apitude\Core\ORM\SimpleHydrator;
use Dbtlr\MigrationProvider\Provider\MigrationServiceProvider;
use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\EventManager;
use Doctrine\ORM\EntityManagerInterface;
use Silex\Application;
use Silex\ServiceProviderInterface;

class DoctrineServiceProvider implements ServiceProviderInterface
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
        $app->register(
            new \Silex\Provider\DoctrineServiceProvider(),
            ['db.options' => $app['config']['db.options']]
        );
        $app->register(
            new DoctrineOrmServiceProvider(),
            $app['config']['orm.options']
        );
        $app->register(new MigrationServiceProvider(), [
            'db.migrations.path' =>$app['config']['migrations.directory'],
        ]);
        $app['orm.em'] = $app->extend('orm.em', function(EntityManagerInterface $em) {
            if (file_exists(APP_PATH.'/vendor/apitude/apitude/src/Annotations/APIAnnotations.php')) {
                AnnotationRegistry::registerFile(APP_PATH.'/vendor/apitude/apitude/src/Annotations/APIAnnotations.php');
            }
            $em->getConfiguration()->addCustomHydrationMode('simple', SimpleHydrator::class);
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
            /** @var EventManager $eventMgr */
            $eventMgr = $app['db.event_manager'];
            foreach ($config['orm.subscribers'] as $class) {
                $eventMgr->addEventSubscriber(new $class());
            }
        }
    }
}
