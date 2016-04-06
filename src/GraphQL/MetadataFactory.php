<?php
namespace Apitude\Core\GraphQL;

use Apitude\Core\API\ClassMetadata;
use Apitude\Core\Provider\ContainerAwareInterface;
use Apitude\Core\Provider\ContainerAwareTrait;

class MetadataFactory implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    private $metadata = [
        'entities' => [],
    ];

    /**
     * @return \Apitude\Core\API\MetadataFactory
     */
    private function getAPIMetadata()
    {
        return $this->container[\Apitude\Core\API\MetadataFactory::class];
    }

    public function getObjectDefinitionFor($identifier)
    {
        
    }

    protected function createDefinition(ClassMetadata $metadata)
    {
        
    }

    private function processEntities()
    {
        $md = $this->getAPIMetadata();
        foreach ($md->getAllClassNames() as $class) {
            $classMeta = $md->getMetadataForClass($class);
        }
    }
}
