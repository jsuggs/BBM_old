<?php

namespace BBM\Tools\Console\Command;

use BBM\Tools\Console\Command\LoadPeople,
    BBM\Tools\Console\Command\LoadTeams,
    Symfony\Components\Console\Input\InputArgument,
    Symfony\Components\Console\Input\InputOption,
    Symfony\Components\Console;

class RunAll extends Console\Command\Command
{
    protected function configure()
    {
        $this
        ->setName('bbm:load-all')
        ->setDescription('Load all data')
        ->setHelp('Load all data');
    }

    protected function execute(Console\Input\InputInterface $input, Console\Output\OutputInterface $output)
    {
        $this->application->findCommand('bbm:load-teams')->execute($input,$output);
        $this->application->findCommand('bbm:load-people')->execute($input,$output);
        $this->application->findCommand('bbm:load-ballparks')->execute($input,$output);
        $this->application->findCommand('bbm:load-games')->execute($input,$output);
    }
}
