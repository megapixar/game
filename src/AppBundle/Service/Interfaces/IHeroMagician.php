<?php

namespace AppBundle\Service\Interfaces;

interface IHeroMagician extends IHero
{
    public function getMana(): int;

    public function setMana(int $mana);
}
