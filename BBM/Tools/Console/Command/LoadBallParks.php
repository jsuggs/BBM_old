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
                $ballpark = new \BBM\Ballpark($data[0]);
                $ballpark->setName($data[1]);
                $ballpark->setNickname($data[2]);
                $ballpark->setCity($data[3]);
                $ballpark->setState($data[4]);
                $ballpark->setDateOpen($data[5]);
                $ballpark->setDateClose($data[6]);
                $ballpark->setLeague($data[7]);
                $ballpark->setNotes($data[8]);
                $em->persist($ballpark);
            }
        }
        fclose($handle);
        $em->flush();
    }
}
