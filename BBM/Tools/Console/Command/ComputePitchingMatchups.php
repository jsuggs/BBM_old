<?php

namespace BBM\Tools\Console\Command;

use BBM\Team,
    BBM\Player,
    BBM\PitchingMatchup,
    BBM\GameRepository,
    Symfony\Components\Console\Input\InputArgument,
    Symfony\Components\Console\Input\InputOption,
    Symfony\Components\Console;

class ComputePitchingMatchups extends Console\Command\Command
{
    protected function configure()
    {
        $this
        ->setName('bbm:compute-pitchingmatchups')
        ->setDescription('Compute the pitching matchups')
        ->setHelp('help?');
    }

    protected function execute(Console\Input\InputInterface $input, Console\Output\OutputInterface $output)
    {
        $em = $this->getHelper('em')->getEntityManager();

        $gameRepository = new GameRepository($em);

        $games = $gameRepository->getAllGames(2);

        $count = 0;

        foreach ($games as $game) {
            $plays = $game->getPlays();
            foreach ($plays as $play) {
                $matchup = new PitchingMatchup();
                $matchup->setGame($play->getGame());
                $matchup->setPitcher($play->getCurrentPitcher());
                $matchup->setBatter($play->getPlayer());
                $matchup->setEvent($play->getEvent());
                $em->persist($matchup);
                $output->writeln($matchup);

                if (($count % 10) == 0) 
                {
                    $em->flush();
                }

                $count++;
            }
        }

        $em->flush();
    }
}
