<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

class AppStartGameCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:start-game')
            ->setDescription('...')
            ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
            ->setHelp('This command will start the game')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        /** @var \Symfony\Component\Console\Helper\QuestionHelper $helper */
        $helper = $this->getHelper('question');

        $questionName = new Question('Please enter the name of your hero, name has to be unique: ', 'Batman');
        $questionName->setNormalizer(function ($value) {
            // $value can be null here
            return $value ? trim($value) : '';
        });

        $questionName->setValidator(function ($answer) {
            if (!is_string($answer) || 'Bundle' !== substr($answer, -6)) {
                throw new \RuntimeException(
                    'The name of the bundle should be suffixed with \'Bundle\''
                );
            }

            return $answer;
        });

        $questionName->setMaxAttempts(3);
        $name = $helper->ask($input, $output, $questionName);
        if ($name) {

        }

        $output->writeln([
            "Hello $name",
            '============',
        ]);
    }

}
