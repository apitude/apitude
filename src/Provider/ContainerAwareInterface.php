<?php
namespace Apitude\Provider;

use Apitude\Application;

interface ContainerAwareInterface
{
    public function setContainer(Application $container);
}
