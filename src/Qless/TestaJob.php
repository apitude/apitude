<?php
namespace Apitude\Core\Qless;

use Apitude\Core\Provider\ContainerAwareInterface;
use Apitude\Core\Provider\ContainerAwareTrait;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Qless\Job;

class TestaJob implements ContainerAwareInterface, QlessAwareInterface, LoggerAwareInterface
{
    use ContainerAwareTrait;
    use QlessAwareTrait;
    use LoggerAwareTrait;

    public function makeTestJob($delaySeconds = 0) {
        return $this->addJob('test', [
            'Test' => 'foo'
        ], TestaJob::class, $delaySeconds);
    }
    public function process(Job $job, array $payload) {
        $this->logger->info('workin on job: '.$job->getId().' with payload: '.json_encode($payload));
        $job->complete();
    }
}
