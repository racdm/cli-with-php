<?php

namespace Cdm\Cli\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;

class GreetCommands extends Command
{
    protected static string $defaultName = 'greet';

    protected function configure(): void
    {
        $this->setName(self::$defaultName)
            ->setDescription('Greet commands')
            ->addArgument('name', InputArgument::REQUIRED, 'The user name')
            ->addOption('upper', 'u', InputOption::VALUE_NONE, 'Showing greeting in uppercase')
            ->addOption('lower', 'l', InputOption::VALUE_NONE, 'Showing greeting in lowercase')
            ->setHelp("This command allows you to display greeting");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');
        $upper = $input->getOption('upper') ?? null;
        $lower = $input->getOption('lower') ?? null;

        $message = "Hello {$name}!";

        if ($upper) {
            $message = strtoupper($message);
        }

        if ($lower) {
            $message = strtolower($message);
        }

        $style = new SymfonyStyle($input, $output);
        $style->success($message);

        return Command::SUCCESS;
    }
}