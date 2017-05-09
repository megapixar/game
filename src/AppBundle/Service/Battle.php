<?php

namespace AppBundle\Service;

use AppBundle\Service\Hero\AbstractHeroFighter;

class Battle
{
    protected $hero;

    protected $enemy;

    protected $logs = [];

    protected $isHeroWin = false;

    /**
     * Battle constructor.
     *
     * @param AbstractHeroFighter $hero
     * @param AbstractFighter     $enemy
     */
    public function __construct(AbstractHeroFighter $hero, AbstractFighter $enemy)
    {
        $this->enemy = $enemy;
        $this->hero = $hero;
    }

    public function processBattle()
    {
        while ($this->hero->getHealth() && $this->enemy->getHealth()) {
            $this->hero->makeDamage($this->enemy->getDamage());
            $this->addEnemyLog($this->enemy->getDamage(), $this->hero->getHealth());

            $this->enemy->makeDamage($this->hero->getDamage());
            $this->addHeroLog($this->hero->getDamage(), $this->hero->getHealth());
        }

        $this->setIsHeroWin($this->hero->getHealth());

        if ($this->isHeroWin) {
            $this->hero->updateLevel(rand(10, 20));
        }
    }

    /**
     * @param $attack
     * @param $health
     */
    public function addEnemyLog($attack, $health)
    {
        $this->logs[] = [
            "Enemy attack <fg=red;options=bold>$attack</> "
            . "Your health <fg=green;options=bold>$health</>",
            "============",
        ];
    }

    /**
     * @param $attack
     * @param $health
     */
    public function addHeroLog($attack, $health)
    {
        $this->logs[] = [
            "Your attack <fg=red;options=bold>$attack</> "
            . "Enemy health <fg=green;options=bold>$health</>",
            "============",
        ];
    }

    /**
     * @return bool
     */
    public function isHeroWin(): bool
    {
        return $this->isHeroWin;
    }

    /**
     * @param bool $isHeroWin
     */
    public function setIsHeroWin(bool $isHeroWin)
    {
        $this->isHeroWin = $isHeroWin;
    }

    /**
     * @return array
     */
    public function getLogs(): array
    {
        return $this->logs;
    }
}
