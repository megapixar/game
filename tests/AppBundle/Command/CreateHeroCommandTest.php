<?php

namespace Tests\AppBundle\Command;

use AppBundle\Command\CreateHeroCommand;
use AppBundle\Entity\Hero;
use AppBundle\Repository\HeroRepository;
use AppBundle\Service\HeroStaticFactory;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class CreateHeroCommandTest extends KernelTestCase
{
    /**
     * @dataProvider listTypes
     */
    public function testExecute($type)
    {
        self::bootKernel();
        $name = 'Test Name';

        $entityManager = $this->getMockRepository(null);
        $entityManager->expects($this->once())
            ->method('persist');
        $entityManager->expects($this->once())
            ->method('flush');

        $command = new CreateHeroCommand($entityManager);
        (new Application(self::$kernel))->add($command);

        $commandTester = new CommandTester($command);

        $commandTester
            ->setInputs([$name, $type])
            ->execute([
                'command' => $command->getName(),
            ]);

        $this->assertContains("Hello $name!!", $commandTester->getDisplay());

        $this->assertContains("Hello again", $commandTester->getDisplay());
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

    public function listTypes()
    {
        return [
            [HeroStaticFactory::MAGICIAN],
            [HeroStaticFactory::ARCHER],
            [HeroStaticFactory::WARRIOR],
        ];
    }

    public function testExecuteNotUniqueName()
    {
        self::bootKernel();
        $name = 'Test Name';

        $application = new Application(self::$kernel);
        $command = new CreateHeroCommand(
            $this->getMockRepository($this->createMock(Hero::class)));
        $application->add($command);

        $commandTester = new CommandTester($command);
        try {
            $commandTester
                ->setInputs([$name, HeroStaticFactory::MAGICIAN])
                ->execute([
                    'command' => $command->getName(),
                ]);
        } catch (\RuntimeException $exception) {
            $this->assertContains("The name of hero has to be unique!", $commandTester->getDisplay());
        }
    }
}
