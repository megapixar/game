<?php

namespace AppBundle\Service\Hero;

use AppBundle\Entity\Hero;
use AppBundle\Service\AbstractFighter;
use AppBundle\Service\Interfaces\IHero;

abstract class AbstractHeroFighter extends AbstractFighter
{
    protected static $initialHealth;
    protected $damage;
    protected $hero;
    protected $level;
    protected $experience;
    protected $levelUpExperience = 100;

    /**
     * AbstractHeroFighter constructor.
     *
     * @param Hero $hero
     */
    public function __construct(Hero $hero = null)
    {
        $this->health = $hero->getHealth();
        $this->level = $hero->getLevel();
        $this->experience = $hero->getExperience();
    }

    /**
     * @param IHero $hero
     */
    protected static function setBaseInitialState(IHero $hero)
    {
        $hero->setHealth(static::$initialHealth);
    }

    /**
     * @return float
     */
    public function getDamage(): float
    {
        return $this->level * $this->damage;
    }

    /**
     * @param int $experience
     */
    public function updateLevel(int $experience)
    {
        $this->experience += $experience;

        if ($this->experience >= $this->levelUpExperience) {
            $this->level += 1;
            $this->experience = $this->experience - $this->levelUpExperience;
        }
    }

    /**
     * @param IHero $hero
     */
    public function exportBaseStates(IHero $hero)
    {
        $hero->setHealth($this->getHealth());
        $hero->setExperience($this->experience);
        $hero->setLevel($this->level);
    }
}
