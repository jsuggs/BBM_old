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


        if (($handle = fopen("../data/teams.csv","r")) !== FALSE) {
            while (($data = fgetcsv($handle)) !== FALSE) {
                $team = new \BBM\Team($data[0],$data[1],$data[2],$data[3]);
                $team->setAddress($data[4],$data[5],$data[6]);
                $output->write($team . "\n");
                $em->persist($team);
            }
        }

        $em->flush();
    }
}
