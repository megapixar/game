<?php

namespace AppBundle\Service;

use AppBundle\Entity\Hero\{
    Archer, Magician, Warrior
};
use AppBundle\Entity\Hero as HeroEntity;
use AppBundle\Service\Hero;
use AppBundle\Service\Interfaces\IHeroArcher;
use AppBundle\Service\Interfaces\IHeroMagician;

class HeroStaticFactory
{
    const MAGICIAN = 'magician';
    const WARRIOR = 'warrior';
    const ARCHER = 'archer';

    protected static $heroClasses = [
        self::MAGICIAN => 'Magician',
        self::WARRIOR => 'Warrior',
        self::ARCHER => 'Archer',
    ];

    /**
     * @param HeroEntity $hero
     *
     * @return Hero\Archer|Hero\Magician|Hero\Warrior
     */
    public static function createFromEntity(HeroEntity $hero)
    {
        switch (true) {
            case $hero instanceof IHeroMagician:
                return new Hero\Magician($hero);
            case $hero instanceof IHeroArcher:
                return new Hero\Archer($hero);
            default:
                return new Hero\Warrior($hero);
        }
    }

    /**
     * @param string $type
     * @param string $name
     *
     * @return HeroEntity
     */
    public static function makeEntity(string $type, string $name): HeroEntity
    {
        if (empty(self::$heroClasses[$type])) {
            throw new \RuntimeException('This class isn\'t supported yet');
        }

        switch ($type) {
            case self::MAGICIAN:
                $hero = new Magician();
                Hero\Magician::setInitialState($hero);
                break;
            case self::ARCHER:
                $hero = new Archer();
                Hero\Archer::setInitialState($hero);
                break;
            default:
                $hero = new Warrior();
                Hero\Warrior::setInitialState($hero);
        }

        $hero->setName($name);

        return $hero;
    }

    /**
     * @return array
     */
    public static function getHeroLabels(): array
    {
        return self::$heroClasses;
    }
}
