<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:hello-world',
    description: 'Training command',
)]
class HelloWorldCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('name', InputArgument::OPTIONAL, 'Tell us your name, so we can say hello to you !', 'World')
            ->addOption('case', 'c', InputOption::VALUE_REQUIRED, 'Define case transformation. "L" for lowercase, "U" for uppercase')
            ->setHelp('This command allows you to send hello to you. You can choose a name and specify a case.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $name = $input->getArgument('name');

        if ($name) {
            $io->note(sprintf('You passed an argument: %s', $name));
        }

        $c = $input->getOption('case');

        if (!$c) {
            $c = $io->choice('Souhaitez-vous un changement de casse ?', [
                'U' => 'Casse haute',
                'L' => 'casse basse',
                'n' => 'pas de changement',
            ]);

            $c = $io->askQuestion(new ChoiceQuestion('Souhaitez-vous un changement de casse ?', [
                'U' => 'Casse haute',
                'L' => 'casse basse',
                'n' => 'pas de changement',
            ]));
        }

        $name = match ($c) {
            'L' => mb_strtolower($name),
            'U' => mb_strtoupper($name),
            default => $name,
        };

        $io->success(sprintf('Hello, %s!', $name));

        return Command::SUCCESS;
    }
}
