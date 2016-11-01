<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RedisCleanerCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('adserver:redis-flush-dbs')
            ->setDescription('Flush Redis DBs.')
            ->addOption('dbs', null, InputOption::VALUE_REQUIRED, 'DBs list, comma separated');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // need for phpmd
        $input->isInteractive();

        $redisHost = $this->getContainer()->getParameter('redis_host');
        $redisPort = $this->getContainer()->getParameter('redis_port');

        $dbList = array_map('trim', explode(',', $input->getOption('dbs')));

        $redis = new \Redis();
        $redis->connect($redisHost, $redisPort);

        $output->writeln('Connection to Redis opened.');

        foreach ($dbList as $db) {
            $redis->select($db);
            $redis->flushDB();
            $output->writeln(sprintf('<info>Flushed DB #%d</info>', $db));
        }

        $redis->close();

        $output->writeln('Connection to Redis closed.');

        return true;
    }
}
