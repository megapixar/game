<?php

namespace AppBundle\Service;

abstract class AbstractFighter
{
    protected $health;

    abstract public function getType(): string;

    abstract public function getDamage(): float;


    public function getHealth(): float
    {
        return $this->health;
    }

    public function setHealth(float $health)
    {
        $this->health = $health;
    }

    public function makeDamage(float $damage)
    {
        $this->health -= $damage;
        $this->health = $this->health >= 0 ? $this->health : 0;
    }
}
