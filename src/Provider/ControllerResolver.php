<?php
namespace Apitude\Core\Provider;

class ControllerResolver extends \Silex\ControllerResolver
{
    /**
     * Returns a callable for the given controller.
     *
     * @param string $controller A Controller string
     *
     * @return mixed A PHP callable
     */
    protected function createController($controller)
    {
        if (false === strpos($controller, '::')) {
            throw new \InvalidArgumentException(sprintf('Unable to find controller "%s".', $controller));
        }
        // standard class:method
        list($class, $method) = explode('::', $controller, 2);
        if (!class_exists($class)) {
            // try as a service identifier
            if (isset($this->app[$class])) {
                $controller = $this->app[$class];
            } else {
                throw new \InvalidArgumentException(sprintf('Class "%s" does not exist.', $class));
            }
        } else {
            $controller = new $class();
        }

        return [$controller, $method];
    }
}
