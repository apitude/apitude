<?php


class AnnotationDriverTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var \Apitude\API\AnnotationDriver
     */
    protected $driver;

    protected function _before()
    {
        require_once (realpath(__DIR__.'/../../vendor').'/autoload.php');
        require_once (
            realpath(
                __DIR__.'/../../vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/Driver'
            ).'/DoctrineAnnotations.php');
        require_once (
            realpath(
                __DIR__.'/../../src/Annotations'
            ).'/APIAnnotations.php');
        require_once (__DIR__.'/assets/AnnotationDriverTest/Person.php');
        $this->driver = new \Apitude\API\AnnotationDriver(
            new \Doctrine\Common\Annotations\AnnotationReader()
        );
    }

    protected function _after()
    {
    }

    // tests
    public function testCanGetClassMetadata()
    {
        $p = new \Entities\Person();

        /** @var \Apitude\API\ClassMetadata $meta */
        $meta = $this->driver->loadMetadataForClass(
            new \ReflectionClass(get_class($p))
        );

        $this->assertTrue($meta->isExposed());
    }
}