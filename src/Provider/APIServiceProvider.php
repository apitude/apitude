<?php
namespace Apitude\Provider;


use Apitude\API\Commands\GetCommand;
use Apitude\API\EntityWriter;
use Silex\Application;

class APIServiceProvider extends AbstractServiceProvider
{
    protected $services = [
        EntityWriter::class,
    ];

    protected $commands = [
        GetCommand::class,
    ];
}
