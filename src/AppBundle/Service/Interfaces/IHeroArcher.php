<?php

namespace AppBundle\Service\Interfaces;

interface IHeroArcher extends IHero
{
    public function getArrows(): int;

    public function setArrows(int $arrows);
}
