<?php
namespace Apitude\Core\Provider;

use Apitude\Core\Application;

interface ContainerAwareInterface
{
    public function setContainer(Application $container);
}
