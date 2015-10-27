<?php
namespace Apitude\Core\Kue;

use Apitude\Core\Provider\ContainerAwareInterface;
use Apitude\Core\Provider\ContainerAwareTrait;
use Kue\Job;
use Kue\Queue;
use Kue\Worker;

class RedisQueue implements Queue, ContainerAwareInterface
{
    use ContainerAwareTrait;

    const DEFAULT_KEY = "spark:queue";

    /** @var string */
    protected $key;

    /** @var \Redis */
    protected $redis;

    function __construct($key = self::DEFAULT_KEY)
    {
        $this->key = $key;
    }

    /**
     * @return \Redis
     */
    private function getRedis() {
        if (!$this->redis) {
            $this->redis = $this->container['redis'];
        }
        return $this->redis;
    }

    /**
     * Does a Redis BLPOP on the queue, and blocks until a job is available.
     *
     * @return Job
     */
    function pop()
    {
        $response = $this->getRedis()->blPop($this->key, 10);

        if ($response) {
            list($list, $serializedJob) = $response;

            $job = unserialize($serializedJob);
            return $job;
        }
    }

    function push(Job $job)
    {
        $this->getRedis()->rPush($this->key, serialize($job));
    }

    function flush()
    {
        # We send jobs directly in `push`, so we don't need to flush
    }

    function process(Worker $worker)
    {
    }
}
