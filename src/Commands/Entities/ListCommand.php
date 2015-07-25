<?php
namespace B2k\Apitude\Commands\Entities;


use B2k\Apitude\Commands\BaseCommand;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ListCommand extends BaseCommand
{
    public function configure()
    {
        parent::configure();

        $this->addArgument('Entity Name');
        $this->addOption('columns', 'c', InputOption::VALUE_IS_ARRAY, 'Columns to show');
        $this->addOption('limit', 'l', InputOption::VALUE_REQUIRED, 'Limit (default all)');
        $this->addOption('start', 's', InputOption::VALUE_REQUIRED, 'Record to start at');
        $this->addOption('filter', 'f', InputOption::VALUE_REQUIRED, 'DQL filter');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();
        /** @var EntityManagerInterface $em */
        $em = $app['em'];
    }
}
