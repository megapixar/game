<?php

namespace Tests\AppBundle\Command;

use AppBundle\Command\CreateHeroCommand;
use AppBundle\Command\StartGameCommand;
use AppBundle\Entity\Hero;
use AppBundle\Service\HeroStaticFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class StartGameCommandTest extends KernelTestCase
{
    /** @var EntityManager */
    private $entityManager;

    /**
     * Sets up environment for testing
     * Regenerates Database schema before every test-run
     */
    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();

        $this->entityManager = static::$kernel->getContainer()
            ->get('doctrine.orm.entity_manager');
        $this->regenerateSchema();
    }

    /**
     * Drops current schema and creates a brand new one
     */
    protected function regenerateSchema()
    {
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();
        if (!empty($metadata)) {
            $tool = new SchemaTool($this->entityManager);
            $tool->dropSchema($metadata);
            $tool->createSchema($metadata);
        }
    }

    /**
     * @dataProvider listTypes
     */
    public function testExecute($name, $type)
    {
        $this->runCreateHero($name, $type);
        $hero = $this->entityManager
            ->getRepository(Hero::class)->findOneBy(['name' => $name]);
        $this->entityManager->clear();

        $command = new StartGameCommand($this->entityManager);
        (new Application(static::$kernel))->add($command);
        $commandTester = new CommandTester($command);

        $commandTester
            ->execute([
                'command' => $command->getName(),
                'name' => $name,
            ]);

        $heroAfterFight = $this->entityManager
            ->getRepository(Hero::class)->findOneBy(['name' => $name]);
        if ($heroAfterFight->getStatistics()->last()->isWin()) {
            $this->assertGreaterThan($hero->getExperience(), $heroAfterFight->getExperience());
            $this->assertLessThan($hero->getHealth(), $heroAfterFight->getHealth());
        } else {
            $this->assertEmpty($heroAfterFight->getExperience());
            $this->assertEmpty($heroAfterFight->getHealth());
        }
    }

    protected function runCreateHero($name, $type)
    {
        $command = new CreateHeroCommand($this->entityManager);
        (new Application(static::$kernel))->add($command);
        $commandTester = new CommandTester($command);

        $commandTester
            ->setInputs([$name, $type])
            ->execute([
                'command' => $command->getName(),
            ]);
    }

    public function listTypes()
    {
        return [
            ['Magician', HeroStaticFactory::MAGICIAN],
            ['Archer', HeroStaticFactory::ARCHER],
            ['Warrior', HeroStaticFactory::WARRIOR],
        ];
    }

    protected function tearDown()
    {
        parent::tearDown();
        $this->entityManager->close();
    }
}
