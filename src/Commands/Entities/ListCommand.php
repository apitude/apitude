<?php
namespace B2k\Apitude\Commands\Entities;


use B2k\Apitude\Commands\BaseCommand;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Symfony\Component\Console\Helper\Table;
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
        $this->addOption('columns', 'c', InputOption::VALUE_IS_ARRAY|InputOption::VALUE_REQUIRED, 'Columns to show');
        $this->addOption('limit', 'l', InputOption::VALUE_REQUIRED, 'Limit (default all)');
        $this->addOption('start', 's', InputOption::VALUE_REQUIRED, 'Record to start at');
        $this->addOption('filter', 'f', InputOption::VALUE_REQUIRED, 'DQL filter');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();
        $entity = $input->getArgument('entity');
        /** @var EntityManagerInterface $em */
        $em = $app['orm.em'];
        $qb = $em->createQueryBuilder()->from($entity, 'main');
        if ($input->getOption('columns')) {
            $qb->select($input->getOption('columns'));
        } else {
            $qb->select('main');
        }
        if ($input->getOption('limit')) {
            $qb->setMaxResults($input->getOption('limit'));
            if ($input->getOption('start') !== null) {
                $qb->setFirstResult($input->getOption('start'));
            }
        }
        if ($input->getOption('filter')) {
            $qb->where($input->getOption('filter'));
        }

        $query = $qb->getQuery();
        $results = $query->getResult('simple');

        if (empty($results)) {
            $output->writeln('<info>No Results</info>');
            return;
        }

        $table = new Table($output);
        $table->setHeaders(array_keys($results[0]));
        $table->addRows($results);
        $table->render();
    }
}
