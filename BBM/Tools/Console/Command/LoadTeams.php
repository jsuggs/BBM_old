<?php

namespace BBM\Tools\Console\Command;

use BBM\Team,
    Symfony\Components\Console\Input\InputArgument,
    Symfony\Components\Console\Input\InputOption,
    Symfony\Components\Console;

class LoadTeams extends Console\Command\Command
{
    protected function configure()
    {
        $this
        ->setName('bbm:load-teams')
        ->setDescription('Load the teams')
        ->setHelp('Load the teams');
    }

    protected function execute(Console\Input\InputInterface $input, Console\Output\OutputInterface $output)
    {
        $em = $this->getHelper('em')->getEntityManager();


        if (($handle = fopen(DATADIR . "/teams/TEAMABR.TXT","r")) !== FALSE) {
            while (($data = fgetcsv($handle)) !== FALSE) {
                $team = new \BBM\Team($data[0]);
                $team->setLeague($data[1]);
                $team->setCity($data[2]);
                $team->setNickname($data[3]);
                $em->persist($team);
            }
        }

        $em->flush();
    }
}
