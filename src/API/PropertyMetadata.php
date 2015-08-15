<?php
namespace Apitude\Core\API;


class PropertyMetadata extends \Metadata\PropertyMetadata
{
    /**
     * @var bool
     */
    private $exposed = false;
    /**
     * @var string|null
     */
    private $renderMethod;
    /**
     * @var string|null
     */
    private $renderService;
    /**
     * @var string
     */
    private $getterMethod;
    /**
     * @var
     */
    private $exposedName;

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getGetterMethod()
    {
        return $this->getterMethod;
    }

    /**
     * @param string $getterMethod
     */
    public function setGetterMethod($getterMethod)
    {
        $this->getterMethod = $getterMethod;
    }

    /**
     * @return string
     */
    public function getRenderService()
    {
        return $this->renderService;
    }

    /**
     * @param string $renderService
     */
    public function setRenderService($renderService)
    {
        $this->renderService = $renderService;
    }

    public function setExposed($bool)
    {
        $this->exposed = $bool;
    }

    public function isExposed()
    {
        return $this->exposed;
    }

    public function setRenderMethod($method)
    {
        $this->renderMethod = $method;
    }

    public function getRenderMethod()
    {
        return $this->renderMethod;
    }

    public function setExposedName($name)
    {
        $this->exposedName = $name;
    }

    public function getExposedName()
    {
        return $this->exposedName ?: $this->name;
    }
}
