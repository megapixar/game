<?php

namespace AppBundle\Service\Enemy;

use AppBundle\Service\AbstractFighter;

class Wolf extends AbstractFighter
{
    protected $health = 15;

    public function getType(): string
    {
        return 'Wolf';
    }

    public function getDamage(): float
    {
        return 5;
    }
}
