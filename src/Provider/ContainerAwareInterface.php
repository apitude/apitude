<?php
namespace B2k\Apitude\Provider;

use B2k\Apitude\Application;

interface ContainerAwareInterface
{
    public function setContainer(Application $container);
}
