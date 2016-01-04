<?php


class MysqlPlatformTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
        require_once (realpath(__DIR__.'/../../vendor').'/autoload.php');
    }

    protected function _after()
    {
    }

    // tests
    public function testMysqlPlatformGuidColumnCreate()
    {
        $platform = new \Apitude\Core\DBAL\MysqlPlatform();

        $string = $platform->getGuidTypeDeclarationSQL([
            'name' => 'test'
        ]);

        $this->assertEquals('CHAR(36) COLLATE ascii_general_ci', $string);
    }

    public function testMysql57PlatformGuidColumnCreate()
    {
        $platform = new \Apitude\Core\DBAL\Mysql57Platform();

        $string = $platform->getGuidTypeDeclarationSQL([
            'name' => 'test'
        ]);

        $this->assertEquals('CHAR(36) COLLATE ascii_general_ci', $string);
    }
}
