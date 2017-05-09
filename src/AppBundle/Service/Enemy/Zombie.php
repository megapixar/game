<?php

namespace AppBundle\Service\Enemy;

use AppBundle\Service\AbstractFighter;

class Zombie extends AbstractFighter
{
    protected $health = 20;

    public function getType(): string
    {
        return 'Zombie';
    }

    public function getDamage(): float
    {
        return 7;
    }
}
