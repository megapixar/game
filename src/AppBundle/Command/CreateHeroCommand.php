<?php

namespace AppBundle\Command;

use AppBundle\Console\Question\UniqueNameQuestion;
use AppBundle\Entity\Hero;
use AppBundle\Service\HeroStaticFactory;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

class CreateHeroCommand extends Command
{
    protected $em;
    protected $heroFactory;

    public function __construct(ObjectManager $objectManager)
    {
        $this->em = $objectManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('app:create-hero')
            ->setDescription('Before start the game please create a hero')
            ->setHelp('This command will start the new game');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var \Symfony\Component\Console\Helper\QuestionHelper $helper */
        $helper = $this->getHelper('question');

        $questionName = new UniqueNameQuestion(
            'Please enter the name of your hero: ', 'Batman',
            $this->em->getRepository(Hero::class)
        );

        $name = $helper->ask($input, $output, $questionName);

        $output->writeln([
            "Hello <info>$name</info>!!",
            '============',
        ]);

        $heroes = HeroStaticFactory::getHeroLabels();

        $questionClass = new ChoiceQuestion(
            'Please select your hero class',
            $heroes
        );

        $type = $helper->ask($input, $output, $questionClass);

        $output->writeln([
            "Hello again <info>{$heroes[$type]} $name</info>!!",
            "Now you are ready for the game, just run",
            "php bin/console app:start-game $name",
            '============',
        ]);
        $hero = HeroStaticFactory::makeEntity($type, $name);

        $this->em->persist($hero);
        $this->em->flush();
    }
}
