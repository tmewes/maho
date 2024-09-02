<?php

namespace MahoCLI\Commands;

use Mage;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'cache:flush',
    description: 'Flush cache'
)]
class CacheFlush extends BaseMahoCommand
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->initMaho();

        Mage::app()->getCacheInstance()->flush();
        Mage::dispatchEvent('adminhtml_cache_flush_all');

        $output->writeln('Caches flushed successfully!');
        return Command::SUCCESS;
    }
}
