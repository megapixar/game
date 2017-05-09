<?php

namespace AppBundle\Service\Hero;

use AppBundle\Service\Interfaces\IHeroArcher;

class Archer extends AbstractHeroFighter
{
    protected static $initialArrows = 5;

    protected static $initialHealth = 20;

    protected $damage = 5;

    protected $hero;

    protected $arrows;

    public function __construct(IHeroArcher $hero = null)
    {
        parent::__construct($hero);
        if ($hero) {
            $this->arrows = $hero->getArrows();
        }
    }

    /**
     * @param IHeroArcher $hero
     */
    public static function setInitialState(IHeroArcher $hero)
    {
        parent::setBaseInitialState($hero);

        $hero->setArrows(self::$initialArrows);
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'Archer';
    }

    /**
     * @return float
     */
    public function getDamage(): float
    {
        $damage = parent::getDamage();
        if ($this->arrows - 1 > 0) {
            $damage *= 2;
            --$this->arrows;
        }

        return $damage;
    }

    /**
     * @param IHeroArcher $hero
     */
    public function exportStates(IHeroArcher $hero)
    {
        parent::exportBaseStates($hero);

        $hero->setArrows(self::$initialArrows);
    }
}
