<?php

namespace Cdm\Cli\Commands;

use Random\RandomException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GeneratePassword extends Command
{
    protected static string $defaultName = 'password';
    protected static string $argLength = 'length';
    protected static string $opSpecial = 'special';

    protected function configure(): void
    {
        $this->setName(self::$defaultName)
            ->setDescription('Random password generator')
            ->addArgument(self::$argLength, InputArgument::OPTIONAL, 'Password length', 8)
            ->addOption(self::$opSpecial, 's', InputOption::VALUE_NONE, 'Add special characters')
            ->setHelp("This command allows you to generate a password");
    }

    /**
     * @throws RandomException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $length = $input->getArgument(self::$argLength);
        $special = $input->getOption(self::$opSpecial) ?? null;

        $password = $this->makePassword($length, $special);

        $output->writeln("Generated Password: ".$password);

        return Command::SUCCESS;
    }

    /**
     * @throws RandomException
     */
    private function makePassword(int $length, ?string $special): string{
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        if ($special) {
            $characters .= "!@#$%^&*()_+-={}[]|:;<>,.?/~`";
        }

        $charactersLength = strlen($characters);
        $randomPassword = '';

        for ($i = 0; $i < $length; $i++) {
            $randomPassword .= $characters[random_int(0, $charactersLength - 1)];
        }

        return $randomPassword;
    }
}