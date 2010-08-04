<?php

namespace BBM\Tools\Console\Command;

use BBM\Ballpark,
    Symfony\Components\Console\Input\InputArgument,
    Symfony\Components\Console\Input\InputOption,
    Symfony\Components\Console;

class LoadBallParks extends Console\Command\Command
{
    protected function configure()
    {
        $this
        ->setName('bbm:load-ballparks')
        ->setDescription('Load the ballparks')
        ->setHelp('Load the ballaprks');
    }

    protected function execute(Console\Input\InputInterface $input, Console\Output\OutputInterface $output)
    {
        $em = $this->getHelper('em')->getEntityManager();


        if (($handle = fopen(DATADIR . "/ballparks/parkcode.txt","r")) !== FALSE) {
            while (($data = fgetcsv($handle)) !== FALSE) {
                //$team = new \BBM\Team($data[0],$data[1],$data[2],$data[3]);
                //$team->setAddress($data[4],$data[5],$data[6]);
                //$output->write($team . "\n");
                //$em->persist($team);
                $output->write($data[0]);
            }
        }

        $em->flush();
    }
}
