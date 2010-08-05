<?php

namespace BBM\Tools\Console\Command;

use Symfony\Components\Console\Input\InputArgument,
    Symfony\Components\Console\Input\InputOption,
    Symfony\Components\Console;

class ReloadAll extends Console\Command\Command
{
    protected function configure()
    {
        $this
        ->setName('bbm:reload-all')
        ->setDescription('Drop and recreate the schema, then load data')
        ->setHelp('Complete reset');
    }

    protected function execute(Console\Input\InputInterface $input, Console\Output\OutputInterface $output)
    {
        $this->application->findCommand('orm:schema-tool:drop')->execute($input,$output);
        //$this->application->findCommand('orm:schema-tool:create')->execute($input,$output);
        //$this->application->findCommand('bbm:load-all')->execute($input,$output);
    }
}
