<?php

namespace BBM\Tools\Console\Command;

use BBM\Player,
    BBM\Coach,
    BBM\Umpire,
    Symfony\Components\Console\Input\InputArgument,
    Symfony\Components\Console\Input\InputOption,
    Symfony\Components\Console;

class LoadPeople extends Console\Command\Command
{
    protected function configure()
    {
        $this
        ->setName('bbm:load-people')
        ->setDescription('Load the players, coaches and umpires')
        ->setHelp('Load the players, coaches and umpires');
    }

    protected function execute(Console\Input\InputInterface $input, Console\Output\OutputInterface $output)
    {
        $em = $this->getHelper('em')->getEntityManager();

        if (($handle = fopen(DATADIR . "/people/people.txt","r")) !== FALSE) {
            while (($data = fgetcsv($handle)) !== FALSE) {
                $type = substr($data[2],5,1);

                switch($type)
                {
                    case 0:
                    case 1:
                        // This is a player
                        $player = new Player($data[2]);
                        $player->setName($data[1],$data[0]);
                        $em->persist($player);
                        break;
                    case 8:
                        // Managers and coaches
                        $coach = new Coach($data[2]);
                        $coach->setName($data[1],$data[0]);
                        $em->persist($coach);
                        break;
                    case 9:
                        // Umpires
                        $umpire = new Umpire($data[2]);
                        $umpire->setName($data[1],$data[0]);
                        $em->persist($umpire);
                        break;
                    default:
                       throw new \Exception('Unknown type of person record');
                }
            }
        }
        fclose($handle);

        $em->flush();
    }
}
