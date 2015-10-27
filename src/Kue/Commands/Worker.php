<?php
namespace Apitude\Core\Kue\Commands;

use Apitude\Core\Commands\BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Worker extends BaseCommand
{
    public function configure()
    {
        $this->setName('kue:worker')
            ->setDescription('Lists specified entity using scalar values in tables');

        $this->addArgument('entity', InputArgument::REQUIRED, 'Entity to list');
        $this->addOption('columns', 'c', InputOption::VALUE_IS_ARRAY|InputOption::VALUE_REQUIRED, 'Columns to show');
        $this->addOption('limit', 'l', InputOption::VALUE_REQUIRED, 'Limit (default all)');
        $this->addOption('start', 's', InputOption::VALUE_REQUIRED, 'Record to start at');
        $this->addOption('filter', 'f', InputOption::VALUE_REQUIRED, 'DQL filter (entity is aliased as "main")');
        parent::configure();
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();


    }
}
