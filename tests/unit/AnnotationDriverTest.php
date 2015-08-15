<?php


class AnnotationDriverTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var \Apitude\Core\API\AnnotationDriver
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
        $this->driver = new \Apitude\Core\API\AnnotationDriver(
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

        /** @var \Apitude\Core\API\ClassMetadata $meta */
        $meta = $this->driver->loadMetadataForClass(
            new \ReflectionClass(get_class($p))
        );

        $this->assertTrue($meta->isExposed());
        $this->assertEquals('Someone', $meta->getExposedName());
    }

    public function testCanGetPropertyMetadata()
    {
        /** @var \Apitude\Core\API\ClassMetadata $meta */
        $meta = $this->driver->loadMetadataForClass(
            new \ReflectionClass(\Entities\Person::class)
        );

        /** @var \Apitude\Core\API\PropertyMetadata[] $props */
        $props = $meta->getPropertyMetadata();

        $this->assertArrayHasKey('id', $props);

        $firstName = $props['firstName'];
        $lastName  = $props['lastName'];
        $created   = $props['created'];
        $createdBy = $props['createdBy'];

        $this->assertEquals('first', $firstName->getExposedName());
        $this->assertEquals('lastName', $lastName->getExposedName());

        $this->assertEquals(\Apitude\Core\API\Writer\PropertyWriter::class, $created->getRenderService());
        $this->assertEquals('renderISODateTime', $created->getRenderMethod());
        $this->assertTrue($createdBy->isExposed());
    }
}