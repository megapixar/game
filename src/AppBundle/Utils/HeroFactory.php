<?php

namespace AppBundle\Utils;

use AppBundle\Entity\{
    Archer, Hero, Magician, Warrior
};

class HeroFactory
{
    const MAGICIAN_ID = 1;
    const WARRIOR_ID = 2;
    const ARCHER_ID = 3;
    protected $em;
    protected $classLabels = [
        self::MAGICIAN_ID => 'Magician',
        self::WARRIOR_ID => 'Warrior',
        self::ARCHER_ID => 'Archer',
    ];

    protected $entityClasses = [
        self::MAGICIAN_ID => Magician::class,
        self::WARRIOR_ID => Warrior::class,
        self::ARCHER_ID => Archer::class,
    ];

    public function makeByLabel(string $classLabel, string $name): Hero
    {
        /** @var Hero $hero */
        $hero = new $this->entityClasses[$this->getClassIDByLabel($classLabel)];
        $hero->setName($name);

        return $hero;
    }

    public function getClassIDByLabel($classLabel)
    {
        $invertLabels = array_flip($this->classLabels);

        if (!isset($invertLabels[$classLabel])) {
            return false;
        }

        return $invertLabels[$classLabel];
    }

    /**
     * @return array
     */
    public function getClassLabels(): array
    {
        return $this->classLabels;
    }

    public function getDefaultClassID(): int
    {
        return self::MAGICIAN_ID;
    }

}