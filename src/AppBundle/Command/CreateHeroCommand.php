<?php

namespace AppBundle\Command;

use AppBundle\Console\Question\UniqueNameQuestion;
use AppBundle\Entity\Hero;
use AppBundle\Utils\HeroFactory;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

class CreateHeroCommand extends Command
{
    protected $em;
    protected $heroFactory;

    public function __construct(ObjectManager $em, HeroFactory $heroFactory = null)
    {
        $this->em = $em;
        $this->heroFactory = $heroFactory;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('app:create-hero')
            ->setDescription('...')
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

        $questionClass = new ChoiceQuestion(
            'Please select your hero class',
            $this->heroFactory->getClassLabels()
        );

        $className = $helper->ask($input, $output, $questionClass);

        $output->writeln([
            "Hello again <info>$className $name</info>!!",
            '============',
        ]);

        $hero = $this->heroFactory->makeByLabel($className, $name);

        $this->em->persist($hero);
        $this->em->flush();
    }
}
