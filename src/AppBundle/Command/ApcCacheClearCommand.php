<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ApcCacheClearCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('adserver:apc-cache-clear')
            ->setDescription('APC cache clear');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // need for phpmd
        $input->isInteractive();

        if (apc_clear_cache()) {
            $output->writeln('<info>APC System Cache cleared out.</info>');
        } else {
            $output->writeln('<error>Error within clearing APC System Cache.</error>');
        }

        if (apc_clear_cache('user')) {
            $output->writeln('<info>APC User Cache cleared out.</info>');
        } else {
            $output->writeln('<error>Error within clearing APC User Cache.</error>');
        }

        if (apcu_clear_cache()) {
            $output->writeln('<info>APCu Cache cleared out.</info>');
        } else {
            $output->writeln('<error>Error within clearing APCu Cache.</error>');
        }

        return true;
    }
}
