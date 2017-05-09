<?php

namespace AppBundle\Service\Hero;

use AppBundle\Service\Interfaces\IHero;

class Warrior extends AbstractHeroFighter
{
    protected static $initialHealth = 40;
    protected $damage = 5;

    /**
     * @param IHero $hero
     */
    public static function setInitialState(IHero $hero)
    {
        parent::setBaseInitialState($hero);
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'Warrior';
    }

    /**
     * @param IHero $hero
     */
    public function exportStates(IHero $hero)
    {
        parent::exportBaseStates($hero);
    }
}
