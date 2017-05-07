<?php

namespace Tests\AppBundle\Command;

use AppBundle\Command\CreateHeroCommand;
use AppBundle\Entity\Hero;
use AppBundle\Repository\HeroRepository;
use AppBundle\Utils\HeroFactory;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class CreateHeroCommandTest extends KernelTestCase
{

    public function testExecute()
    {
        self::bootKernel();
        $name = 'Test Name';

        $application = new Application(self::$kernel);
        $heroFactory = new HeroFactory();
        $command = new CreateHeroCommand($this->getMockRepository(null), $heroFactory);
        $application->add($command);

        $commandTester = new CommandTester($command);

        $commandTester
            ->setInputs([$name, HeroFactory::MAGICIAN_ID])
            ->execute([
                'command' => $command->getName(),
            ]);

        $this->assertContains("Hello $name!!", $commandTester->getDisplay());

        $class = $heroFactory->getClassLabels()[HeroFactory::MAGICIAN_ID];

        $this->assertContains("Hello again $class $name!!", $commandTester->getDisplay());
    }

    protected function getMockRepository($value)
    {
        // Now, mock the repository so it returns the mock of the employee
        $heroRepository = $this
            ->getMockBuilder(HeroRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $heroRepository->expects($this->atLeastOnce())
            ->method('findOneBy')
            ->will($this->returnValue($value));

        // Last, mock the EntityManager to return the mock of the repository
        $entityManager = $this
            ->getMockBuilder(ObjectManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager->expects($this->atLeastOnce())
            ->method('getRepository')
            ->will($this->returnValue($heroRepository));

        return $entityManager;
    }

    public function testExecuteNotUniqueName()
    {
        self::bootKernel();
        $name = 'Test Name';

        $application = new Application(self::$kernel);
        $heroFactory = new HeroFactory();
        $command = new CreateHeroCommand(
            $this->getMockRepository($this->createMock(Hero::class)),
            $heroFactory);
        $application->add($command);

        $commandTester = new CommandTester($command);
        try {
            $commandTester
                ->setInputs([$name, HeroFactory::MAGICIAN_ID])
                ->execute([
                    'command' => $command->getName(),
                ]);
        } catch (\RuntimeException $exception) {
            $this->assertContains("The name of hero has to be unique!", $commandTester->getDisplay());
        }
    }
}
