<?php
namespace Apitude\Core\API\Writer;


use Apitude\Core\API\ClassMetadata;
use Apitude\Core\API\MetadataFactory;
use Apitude\Core\API\PropertyMetadata;
use Apitude\Core\Provider\ContainerAwareInterface;
use Apitude\Core\Provider\ContainerAwareTrait;
use Doctrine\Common\Collections\Collection;

class ArrayWriter implements WriterInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @return MetadataFactory
     */
    protected function getMetadataFactory()
    {
        return $this->container[MetadataFactory::class];
    }

    protected function getMetadataForObject($object)
    {
        return $this->getMetadataFactory()->getMetadataForClass(get_class($object));
    }

    protected function getUser()
    {
        return $this->container['user'];
    }

    public function writeObject($object)
    {
        $data = [];
        $meta = $this->getMetadataForObject($object);

        if (!$meta || !$meta instanceof ClassMetadata || !$meta->isExposed()) {
            return null;
        }

        $data['@type'] = $meta->getExposedName();
        /** @var PropertyMetadata $propMeta */
        foreach ($meta->getPropertyMetadata() as $propMeta) {
            if (!$propMeta->isExposed()) {
                continue;
            }

            if (count($propMeta->getAccessRoles())) {
                $exposeToUser = false;
                $accessRoles  = $propMeta->getAccessRoles();

                foreach ($this->getUser()->getRoles() as $role) {
                    if (in_array($role, $accessRoles)) {
                        $exposeToUser = true;
                    }
                }

                if (!$exposeToUser) {
                    continue;
                }
            }

            if ($propMeta->getGetterMethod()) {
                $getter = $propMeta->getGetterMethod();
                $value = $object->$getter();
            } else {
                $value = $object->{$propMeta->getName()};
            }

            if ($propMeta->getRenderService()) {
                $service = $this->container[$propMeta->getRenderService()];
                $method = $propMeta->getRenderMethod() ?: 'render';
                $value = $service->{$method}($value);
            }

            if (is_array($value)) {
                if (isset($value[0]) && is_object($value[0])) {
                    $value = $this->writeObjectArray($value);
                }
            }

            if ($value instanceof Collection) {
                $value = $this->writeCollection($value);
            }

            if (is_object($value)) {
                $value = $this->writeObject($value);
            }

            $data[$propMeta->getExposedName()] = $value;
        }

        return $data;
    }

    /**
     * @param array $collection
     * @return array
     */
    public function writeCollection($collection)
    {
        $result = [
            'count' => count($collection),
            'data'  => [],
        ];
        foreach ($collection as $entity) {
            $result['data'][] = $this->writeObject($entity);
        }

        return $result;
    }

    /**
     * @param  array $array
     * @param  int   $totalRecords
     * @param  int   $page
     * @param  int   $resultsPerPage
     * @return array
     */
    public function writeObjectArrayWithPagination(array $array, $totalRecords, $page, $resultsPerPage)
    {
        $result = [
            'total'          => $totalRecords,
            'page'           => $page,
            'resultsPerPage' => $resultsPerPage,
            'data'           => [],
        ];

        $result['data'] = $this->writeObjectArray($array);

        return $result;
    }

    /**
     * @param  array  $array
     * @return array
     */
    public function writeObjectArray(array $array)
    {
        $result = [];

        foreach ($array as $entity) {
            $result[] = $this->writeObject($entity);
        }

        return $result;
    }
}
