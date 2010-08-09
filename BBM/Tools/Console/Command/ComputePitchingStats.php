<?php

namespace BBM\Tools\Console\Command;

use BBM\Team,
    BBM\Player,
    BBM\PitchingMatchup,
    BBM\PlayerRepository,
    Symfony\Components\Console\Input\InputArgument,
    Symfony\Components\Console\Input\InputOption,
    Symfony\Components\Console;

class ComputePitchingStats extends Console\Command\Command
{
    protected function configure()
    {
        $this
        ->setName('bbm:compute-pitchingstats')
        ->setDescription('Compute the pitching statistics')
        ->setHelp('help?');
    }

    protected function execute(Console\Input\InputInterface $input, Console\Output\OutputInterface $output)
    {
        $em = $this->getHelper('em')->getEntityManager();

        $playerRepository = new PlayerRepository($em);

        $pitchers = $playerRepository->getAllPitchers();

        $count = 0;

        $stats = array();

        foreach ($pitchers as $pitcher) {
            $output->writeln($pitcher);
            $matchups = $pitcher->getPitchingMatchupsAsPitcher();

            $runsAllowed = 0;
            $totalMatchups = 0;

            foreach ($matchups as $matchup) {
                $runsAllowed += $matchup->getRunsScored();
                //$output->writeln($matchup);
                $totalMatchups++;
            }

            $output->writeln('Total Matchups: ' . $totalMatchups);
            $output->writeln('Runs allowed: ' . $runsAllowed);
        }
    }
}
