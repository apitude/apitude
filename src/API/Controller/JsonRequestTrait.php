<?php
namespace Apitude\Core\API\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;

trait JsonRequestTrait
{
    /**
     * @param Request $request
     * @return array
     */
    protected function getJsonContents(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        if ($data === null) {
            throw new NotAcceptableHttpException('INVALID_PAYLOAD');
        }

        return $data;
    }
}