<?php
namespace Apitude\Core\Qless;

use Qless\Client;
use Qless\Job;

interface QlessAwareInterface
{
    /**
     * @return Client
     */
    function getJobManager();

    /**
     * @param string $queue
     * @param array $payload
     * @param string $service
     * @param int $delay
     * @param null|string $method
     * @return Job
     */
    function addJob($queue, $payload, $service, $delay=0, $method=null);

    /**
     * @param $jid
     * @return Job
     */
    function getJob($jid);

    /**
     * @param $jid
     * @return boolean
     */
    function cancelJob($jid);
}