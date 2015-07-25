<?php
namespace B2k\Apitude\Commands\Entities;


use B2k\Apitude\Commands\BaseCommand;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Helper\TableHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ListCommand extends BaseCommand
{
    public function configure()
    {
        $this->setName('entity:list');
        parent::configure();

        $this->addArgument('entity', InputArgument::REQUIRED, 'Entity to list');
//        $this->addOption('columns', 'c', InputOption::VALUE_IS_ARRAY, 'Columns to show');
        $this->addOption('limit', 'l', InputOption::VALUE_REQUIRED, 'Limit (default all)');
        $this->addOption('start', 's', InputOption::VALUE_REQUIRED, 'Record to start at');
        $this->addOption('filter', 'f', InputOption::VALUE_REQUIRED, 'DQL filter');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();
        $entity = $input->getArgument('entity');
        /** @var EntityManagerInterface $em */
        $em = $app['em'];
        $qb = $em->createQueryBuilder()->from($entity, 'main');
        if ($input->hasOption('limit')) {
            $qb->setMaxResults($input->getOption('limit'));
            if ($input->hasOption('start')) {
                $qb->setFirstResult($input->getOption('start'));
            }
        }
        if ($input->hasOption('filter')) {
            $qb->where($input->getOption('filter'));
        }
        $results = $qb->getQuery()->getArrayResult();
        if (empty($results)) {
            $output->writeln('<info>No Results</info>');
            return;
        }

        /** @var TableHelper $table */
        $table = $this->getHelper('table');
        $table->setHeaders(array_keys($results[0]));
        $table->addRows($results);
        $table->render($output);
    }
}
