<?php
namespace Apitude\API;


use Metadata\MergeableClassMetadata;

class ClassMetadata extends MergeableClassMetadata
{
    private $exposed = false;

    private $exposedName;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getPropertyMetadata()
    {
        return $this->propertyMetadata;
    }

    public function setExposed($bool)
    {
        $this->exposed = $bool;
    }

    public function isExposed()
    {
        return $this->exposed;
    }

    public function setExposedName($name)
    {
        $this->exposedName = $name;
    }

    /**
     * Returns either the configured exposure name or the dotted class name by default
     * @return string
     */
    public function getExposedName()
    {
        return $this->exposedName ?: str_replace('\\', '.', trim($this->name, '\\'));
    }
}
