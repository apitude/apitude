<?php
namespace Apitude\Core\Provider;

use Apitude\Core\GraphQL\Controller\APIController;

class GraphQLServiceProvider extends AbstractServiceProvider
{
    protected $services = [
        APIController::class,
    ];
}
