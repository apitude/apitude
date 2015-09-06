<?php
namespace Apitude\Core\API\Helper;


use Apitude\Core\Provider\ContainerAwareInterface;
use Apitude\Core\Provider\ContainerAwareTrait;

class EntityPopulator implements ContainerAwareInterface
{
    use ContainerAwareTrait;
    /**
     * Create entity and assign entity properties using an array
     *
     * @param string $class
     * @param array $attributes assoc array of values to assign
     * @return  $class
     * @throws InvalidPropertyException
     */
    public function createFromArray($class, array $attributes)
    {
        $entity = new $class();
        foreach ($attributes as $name => $value) {
            if (property_exists($this, $name)) {
                $methodName = $this->getSetterName($entity, $name);
                if ($methodName) {
                    $entity->{$methodName}($value);
                } else {
                    throw new InvalidPropertyException('Add/Setter method for property '.$name.' not found');
                }
            }
        }

        return $entity;
    }

    /**
     * Create entity and assign entity properties using an array
     *
     * @param $entity
     * @param array $attributes assoc array of values to assign
     * @return $entity
     * @throws InvalidPropertyException
     */
    public function updateFromArray($entity, array $attributes)
    {
        foreach ($attributes as $name => $value) {
            if (property_exists($this, $name)) {
                $methodName = $this->getSetterName($entity, $name);
                if ($methodName) {
                    $entity->{$methodName}($value);
                } else {
                    throw new InvalidPropertyException('Add/Setter method for property '.$name.' not found');
                }
            }
        }

        return $entity;
    }

    /**
     * Get property setter method name (if exists)
     *
     * @param object $entity
     * @param string $propertyName
     * @return false|string
     */
    protected function getSetterName($entity, $propertyName)
    {
        $prefixes = ['add', 'set'];

        foreach ($prefixes as $prefix) {
            $methodName = sprintf('%s%s', $prefix, ucfirst(strtolower($propertyName)));

            if (method_exists($entity, $methodName)) {
                return $methodName;
            }
        }
        return false;
    }
}
