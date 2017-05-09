<?php

namespace AppBundle\Service\Hero;

use AppBundle\Service\Interfaces\IHeroMagician;

class Magician extends AbstractHeroFighter
{
    protected static $initialMana = 10;

    protected static $initialHealth = 20;

    protected $damage = 5;

    protected $mana;

    protected $magicDamageMultiply = 3;

    protected $manaCostPerSpell = 5;

    public function __construct(IHeroMagician $hero)
    {
        parent::__construct($hero);

        $this->mana = $hero->getMana();
    }

    /**
     * @param IHeroMagician $hero
     */
    public static function setInitialState(IHeroMagician $hero)
    {
        parent::setBaseInitialState($hero);

        $hero->setMana(self::$initialMana);
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'Magician';
    }

    /**
     * @return float
     */
    public function getDamage(): float
    {
        $damage = parent::getDamage();
        if ($this->mana - $this->manaCostPerSpell > 0) {
            $damage *= $this->magicDamageMultiply;

            $this->mana -= $this->manaCostPerSpell;
            $this->mana = $this->mana >= 0 ? $this->mana : 0;
        }

        return $damage;
    }

    /**
     * @param IHeroMagician $hero
     */
    public function exportStates(IHeroMagician $hero)
    {
        parent::exportBaseStates($hero);

        $hero->setMana($this->mana);
    }
}
