<?php
namespace Apitude\Core\Qless;

use Qless\Client;
use Qless\Job;
use Silex\Application;

/**
 * Class QlessAwareTrait
 * @package Apitude\Core\Qless
 * @property Application container
 */
trait QlessAwareTrait
{
    /**
     * @return Client
     */
    function getJobManager() {
        return $this->container['qless.client'];
    }

    /**
     * @param string $queue
     * @param array $payload
     * @param string $service
     * @param int $delay
     * @param null|string $method
     * @return string Job ID
     */
    function addJob($queue, $payload, $service, $delay=0, $method=null) {
        $data = [
            'payload' => $payload,
            'service' => $service,
        ];
        if ($method) {
            $data['method'] = $method;
        }
        $jid = sha1(microtime());
        return $this->getJobManager()->put(null, $queue, $jid, null, json_encode($data), $delay);
    }

    /**
     * @param $jid
     * @return Job
     */
    function getJob($jid) {
        return $this->getJobManager()->getJobs()->get($jid);
    }

    /**
     * @param $jid
     * @return boolean
     */
    function cancelJob($jid) {
        $this->getJobManager()->cancel($jid);
    }
}
