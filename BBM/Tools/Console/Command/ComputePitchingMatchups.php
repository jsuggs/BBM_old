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

        $games = $gameRepository->getAllGames();

        $count = 0;

        foreach ($games as $game) {
            $output->writeln($game);
            $plays = $game->getPlays();
            foreach ($plays as $play) {
                $matchup = new PitchingMatchup();
                $matchup->setGame($play->getGame());
                $matchup->setPitcher($play->getCurrentPitcher());
                $matchup->setBatter($play->getPlayer());
                $matchup->setOutcome($play->getEventOutcome());
                //$em->persist($matchup);
                $output->writeln($matchup . ' ' . $play->getEvent() . ' == ' . $play->getEventOutcome());

                if (1==1 || ($count % 10) == 0) 
                {
                    $em->flush();
                    $em->clear();
                }

                $count++;
            }
        }

        $em->flush();
    }
}
