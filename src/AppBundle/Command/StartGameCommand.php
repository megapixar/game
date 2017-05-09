<?php

namespace AppBundle\Command;

use AppBundle\Entity\Hero;
use AppBundle\Service\Battle;
use AppBundle\Service\Enemy\EnemyStaticFactory;
use AppBundle\Service\HeroStaticFactory;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StartGameCommand extends Command
{
    protected $objectManager;
    protected $heroFactory;

    /**
     * StartGameCommand constructor.
     *
     * @param ObjectManager          $objectManager
     * @param HeroStaticFactory|null $heroFactory
     */
    public function __construct(ObjectManager $objectManager, HeroStaticFactory $heroFactory = null)
    {
        $this->objectManager = $objectManager;
        $this->heroFactory = $heroFactory;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('app:start-game')
            ->setDescription('This command starts the game')
            ->addArgument('name', InputArgument::REQUIRED, 'Hero name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $heroEntity = $this->objectManager->getRepository(Hero::class)
            ->findOneBy(['name' => $input->getArgument('name')]);

        if (!$heroEntity) {
            $output->writeln([
                "============",
                "There is no hero <fg=green;options=bold>{$input->getArgument('name')}</> "
                . "please run <fg=yellow;options=bold>app:create-hero</>",
                "============",
            ]);

            return;
        }

        $enemyFighter = EnemyStaticFactory::createRandom();

        if (!$heroEntity->getHealth()) {
            $output->writeln([
                "============",
                "Sorry you have no health, you have to rest",
                "============",
            ]);

            return;
        }

        $heroFighter = HeroStaticFactory::createFromEntity($heroEntity);

        (new Table($output))
            ->setHeaders([$heroEntity->getName(), 'State', $enemyFighter->getType()])
            ->setRows([
                [$heroFighter->getHealth(), 'Health', $enemyFighter->getHealth()],
                [$heroFighter->getDamage(), 'Damage', $enemyFighter->getDamage()],
            ])->render();

        $battle = new Battle($heroFighter, $enemyFighter);
        $battle->processBattle();

        $heroEntity->statistic($enemyFighter->getType(), $battle->isHeroWin());

        $heroFighter->exportStates($heroEntity);

        $this->objectManager->persist($heroEntity);
        $this->objectManager->flush();

        foreach ($battle->getLogs() as $log) {
            $output->writeln($log);
        }
    }
}
