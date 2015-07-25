<?php
namespace B2k\Apitude\Commands\Entities;

use B2k\Apitude\Commands\BaseCommand;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TypesCommand extends BaseCommand
{
    public function configure()
    {
        $this->setName('entity:types')
            ->setDescription('Lists types of entities registered with entity manager');
        parent::configure();
    }
    public function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var EntityManagerInterface $em */
        $em = $this->getSilexApplication()['orm.em'];
        /** @var ClassMetadata[] $types */
        $types = $em->getMetadataFactory()->getAllMetadata();
        foreach ($types as $meta) {
            $output->writeln($meta->getName());
        }
    }
}
