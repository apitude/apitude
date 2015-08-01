<?php
namespace Apitude\API;


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
}
