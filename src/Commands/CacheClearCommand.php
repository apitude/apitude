<?php
namespace Apitude\Core\Commands;

use Doctrine\Common\Cache\CacheProvider;
use Doctrine\ORM\Cache;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CacheClearCommand extends BaseCommand
{
    public function configure()
    {
        parent::configure();
        $this->setName('cache:clear')
            ->setDescription('Clears cache records');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var CacheProvider $cache */
        $cache = $this->getSilexApplication()['cache'];
        $cache->flushAll();
        $output->writeln('<info>Cache Cleared</info>');
    }
}
