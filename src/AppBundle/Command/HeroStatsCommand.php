<?php

namespace AppBundle\Command;

use AppBundle\Entity\Hero;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HeroStatsCommand extends ContainerAwareCommand
{
    protected $objectManager;
    protected $heroFactory;

    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct();

        $this->objectManager = $objectManager;
    }

    protected function configure()
    {
        $this->setName('app:hero-stats')
            ->setDescription('Show heroes statistics');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $table = (new Table($output))
            ->setHeaders(['Name', 'Class', 'Level', 'Experience', 'Health', 'Stats']);

        $heroes = $this->objectManager
            ->getRepository(Hero::class)->findForStatistic();

        $table->addRows($heroes)
            ->render();
    }

}
