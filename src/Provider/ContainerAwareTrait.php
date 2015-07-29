<?php
namespace Apitude\Provider;

use Apitude\Application;

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
