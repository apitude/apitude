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
    protected function getJobManager() {
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
    protected function addJob($queue, $payload, $service, $delay=0, $method=null) {
        $data = [
            'payload' => $payload,
            'service' => $service,
        ];
        if ($method) {
            $data['method'] = $method;
        }
        return $this->getJobManager()->put(null, $queue, null, null, $payload, $delay);
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