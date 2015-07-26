<?php
namespace B2k\Apitude\API\Commands;


use B2k\Apitude\API\EntityWriter;
use B2k\Apitude\Commands\BaseCommand;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetCommand extends BaseCommand
{
    public function configure()
    {
        $this->setName('api:get')
            ->addArgument('class', InputArgument::REQUIRED, 'Entity class')
            ->addArgument('id', InputArgument::REQUIRED, 'Entity ID');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();
        $entity = $input->getArgument('entity');
        $id = $input->getArgument('id');

        /** @var EntityManagerInterface $em */
        $em = $app['orm.em'];

        $entity = $em->find($entity, $id);
        if (!$entity) {
            $output->writeln('Not found');
        } else {
            $writer = $app[EntityWriter::class];
        }
    }
}
