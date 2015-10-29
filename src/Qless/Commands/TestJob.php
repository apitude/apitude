<?php
namespace Apitude\Core\Qless\Commands;

use Apitude\Core\Commands\BaseCommand;
use Apitude\Core\Qless\TestaJob;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestJob extends BaseCommand
{
    public function configure()
    {
        $this->setName('qless:testjob')
            ->setDescription('Add a test job to the "test" queue')
            ->addArgument('delay', InputArgument::OPTIONAL, 'Seconds to delay job', 0);
        parent::configure();
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();
        /** @var TestaJob $testjob */
        $testjob = $app[TestaJob::class];
        $jid = $testjob->makeTestJob(intval($input->getArgument('delay')));
        $output->writeln('Added job '.$jid.' to queue');
    }
}
