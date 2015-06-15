<?php
namespace B2k\Apitude\Provider;

use B2k\Apitude\Application;

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
