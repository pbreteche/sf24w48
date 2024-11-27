<?php

namespace App\Command;

use App\Service\HTMLNamedColors;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:select-color',
    description: 'Training command',
)]
class ColorSelectorCommand extends Command
{
    public function __construct(
        private readonly HTMLNamedColors $colors,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $question = new Question('Please enter a color name: ');
        $question->setAutocompleterCallback($this->colors->getColors(...));

        $io->askQuestion($question);

        return Command::SUCCESS;
    }
}
