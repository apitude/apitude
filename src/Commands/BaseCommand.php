<?php
namespace Apitude\Core\Commands;


use Knp\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class BaseCommand extends Command
{
    protected $startTime;
    protected $baseMemory;

    public function configure()
    {
        parent::configure();

        $this->addOption('time', 'T', InputOption::VALUE_NONE, 'Time command');
        $this->addOption('memory', 'M', InputOption::VALUE_NONE, 'Show memory usage');
    }

    public function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);
        if ($input->hasOption('time') && $input->getOption('time')) {
            $this->startTime = microtime(true);
        }

        if ($input->hasOption('memory') && $input->getOption('memory')) {
            $this->baseMemory = memory_get_peak_usage(true);
        }

        foreach ($this->getSilexApplication()['console.prerun'] as $callback) {
            $callback($this, $input, $output);
        }
    }

    public function run(InputInterface $input, OutputInterface $output)
    {
        $result = parent::run($input, $output);

        if ($input->hasOption('time') && $input->getOption('time')) {
            $totalTime = microtime(true) - $this->startTime;
            $output->writeln('Command completed in <info>'.$totalTime.'</info> seconds');
        }

        if ($input->hasOption('memory') && $input->getOption('memory')) {
            $mem = memory_get_peak_usage(true);
            $output->writeln('Base memory usage at start of command: <info>'.$this->baseMemory.'</info>');
            $output->writeln('Peak memory usage: <info>'.$mem.'</info>');
            $output->writeln('Memory difference: <info>'.($mem - $this->baseMemory).'</info>');
        }

        foreach ($this->getSilexApplication()['console.postrun'] as $callback) {
            $callback($this, $input, $output);
        }

        return $result;
    }
}
