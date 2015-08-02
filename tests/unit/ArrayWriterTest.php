<?php


class ArrayWriterTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    /**
     * @var \Apitude\API\Writer\ArrayWriter
     */
    protected $writer;
    protected $app;

    protected function _before()
    {
        if (!$this->app) {
            $this->app = require realpath(__DIR__.'/../_assets').'/bootstrap.php';
        }
        require_once (__DIR__.'/assets/AnnotationDriverTest/Person.php');
        require_once (__DIR__.'/assets/ArrayWriterTest/User.php');
        $this->writer = new \Apitude\API\Writer\ArrayWriter();
        $this->writer->setContainer($this->app);
    }

    protected function _after()
    {
    }

    private function getPerson()
    {
        $p = new \Entities\Person();

        $p->setFirstName('Bob')
            ->setLastName('McBob')
            ->setCreated(new \DateTime('2015-01-01T13:00:00Z'))
            ->setModified(new \DateTime('2015-01-01T14:00:00Z'))
            ->setCreatedBy((new \Entities\User())->setUsername('admin'));

        return $p;
    }
    // tests
    public function testArrayWriterReturnsArray()
    {
        $p = $this->getPerson();

        $result = $this->writer->writeObject($p);

        $this->assertInternalType('array', $result);
        $this->assertEquals('Someone', $result['@type']);
        $this->assertInternalType('array', $result['createdBy']);
        $this->assertArrayHasKey('first', $result);
        $this->assertEquals('Bob', $result['first']);
        $this->assertEquals('2015-01-01T13:00:00+00:00', $result['created']);
        $this->assertEquals('2015-01-01T14:00:00+00:00', $result['modified']);
        $this->assertEquals('Entities.User', $result['createdBy']['@type']);
    }
}