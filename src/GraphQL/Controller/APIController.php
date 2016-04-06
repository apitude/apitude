<?php
namespace Apitude\Core\GraphQL\Controller;

use Apitude\Core\GraphQL\MetadataFactory;
use Apitude\Core\Provider\ContainerAwareInterface;
use Apitude\Core\Provider\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\Request;

class APIController implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @return MetadataFactory
     */
    private function getMetadataFactory()
    {
        return $this->container[MetadataFactory::class];
    }

    public function handleQuery(Request $request)
    {
        $query = $request->getContent();
        
    }
}
