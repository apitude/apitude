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
            ->setDescription('Return a sample API response of a specified Entity')
            ->addArgument('class', InputArgument::REQUIRED, 'Entity class')
            ->addArgument('id', InputArgument::REQUIRED, 'Entity ID');

        parent::configure();
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApplication();
        $entity = $input->getArgument('class');
        $id = $input->getArgument('id');

        /** @var EntityManagerInterface $em */
        $em = $app['orm.em'];

        $entity = $em->find($entity, $id);
        if (!$entity) {
            $output->writeln('Not found');
        } else {
            /** @var EntityWriter $writer */
            $writer = $app[EntityWriter::class];
            $data = $writer->getArrayForEntity($entity);
            $output->writeln(json_encode($data, JSON_PRETTY_PRINT));
        }
    }
}
