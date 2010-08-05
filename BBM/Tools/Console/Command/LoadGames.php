<?php

namespace BBM\Tools\Console\Command;

use BBM\Ballpark,
    BBM\GameFactory,
    Symfony\Components\Console\Input\InputArgument,
    Symfony\Components\Console\Input\InputOption,
    Symfony\Components\Console;
/**
 * Load Games
 * @todo Fix the looping
 */
class LoadGames extends Console\Command\Command
{
    protected function configure()
    {
        $this
        ->setName('bbm:load-games')
        ->setDescription('Load the games')
        ->setHelp('Load the games');
    }

    protected function execute(Console\Input\InputInterface $input, Console\Output\OutputInterface $output)
    {
        $em = $this->getHelper('em')->getEntityManager();
        $gameFactory = new GameFactory($em);
        $currec = array();

        if (($handle = fopen(DATADIR . "/game_events/2008ATL.EVN","r")) !== FALSE) {
            while (($data = fgetcsv($handle)) !== FALSE) {
                if ($data[0] === 'id' && (sizeof($currec) !== 0)) {
                    $game = $gameFactory->createGameFromRetrosheetRecords($currec);
                    unset($currec);
                }
                else {
                    $currec[] = $data;
                }
                //$output->write($game . "\n");
                //$em->persist($game);
            }
        }
        //$em->flush();
    }
}
