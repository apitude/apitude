<?php
namespace Apitude\Core\Provider;

use Apitude\Core\Application;

trait ContainerAwareTrait
{
    /**
     * @var Application
     */
    protected $container;

    public function setContainer(Application $container)
    {
        $this->container = $container;
    }
}
