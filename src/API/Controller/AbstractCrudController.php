<?php
namespace Apitude\Core\API\Controller;

use Apitude\Core\API\Helper\APIEntityHelperTrait;
use Apitude\Core\API\Helper\EntityPopulator;
use Apitude\Core\API\Writer\ArrayWriter;
use Apitude\Core\API\Writer\WriterInterface;
use Apitude\Core\Application;
use Apitude\Core\Provider\ContainerAwareInterface;
use Apitude\Core\Provider\ContainerAwareTrait;
use Apitude\Core\Provider\Helper\EntityManagerAwareTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AbstractCrudController
 *
 * In most cases this controller should NOT be used in production as it has no validation
 *
 * @package Apitude\Core\API\Controller
 */
abstract class AbstractCrudController implements ContainerAwareInterface
{
    use ContainerAwareTrait;
    use APIEntityHelperTrait;
    use EntityManagerAwareTrait;

    protected $apiRecordType;
    /**
     * @var WriterInterface
     */
    private $apiWriter;

    /**
     * @return WriterInterface
     */
    protected function getApiWriter() {
        if (!$this->apiWriter) {
            $this->apiWriter = $this->container[$this->apiWriterClass];
        }
        return $this->apiWriter;
    }

    protected $apiWriterClass = ArrayWriter::class;

    /**
     * @return EntityPopulator
     */
    private function getEntityPopulator()
    {
        return $this->container[EntityPopulator::class];
    }

    public function create(Request $request)
    {
        $populator = $this->getEntityPopulator();

        $class = $this->getEntityClassFromType($this->apiRecordType);

        $data = $request->getContent();

        if ($request->getContentType() === 'application/json') {
            $data = json_decode($data, true);
        }

        $entity = $populator->createFromArray($class, $data);

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        return new JsonResponse($this->getApiWriter()->writeObject($entity), Response::HTTP_CREATED);
    }

    /**
     * Note that route must be set up to include an id parameter
     *
     * @param $id
     * @return JsonResponse|Response
     * @internal param Request $request
     */
    public function read($id)
    {
        $class = $this->getEntityClassFromType($this->apiRecordType);
        $entity = $this->getEntityManager()->find($class, $id);

        if (!$entity) {
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($this->getApiWriter()->writeObject($entity), Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $class = $this->getEntityClassFromType($this->apiRecordType);
        $entity = $this->getEntityManager()->find($class, $id);

        if (!$entity) {
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $data = $request->getContent();

        if ($request->getContentType() === 'application/json') {
            $data = json_decode($data, true);
        }

        $entity = $this->getEntityPopulator()->updateFromArray($entity, $data);
        $this->getEntityManager()->flush();

        return new JsonResponse($this->getApiWriter()->writeObject($entity), Response::HTTP_OK);
    }

    /**
     * @param $id
     * @return Response
     */
    public function delete($id)
    {
        $class = $this->getEntityClassFromType($this->apiRecordType);
        $entity = $this->getEntityManager()->find($class, $id);

        if (!$entity) {
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * @return JsonResponse
     */
    public function readList()
    {
        $class = $this->getEntityClassFromType($this->apiRecordType);

        $result = $this->getEntityManager()->getRepository($class)
            ->findAll();

        $collection = new ArrayCollection($result);

        return new JsonResponse($this->getApiWriter()->writeCollection($collection), Response::HTTP_OK);
    }
}
