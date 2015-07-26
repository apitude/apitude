<?php
namespace B2k\Apitude\Provider;


use B2k\Apitude\API\Commands\GetCommand;
use B2k\Apitude\API\EntityWriter;
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
