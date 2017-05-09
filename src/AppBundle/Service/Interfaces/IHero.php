<?php

namespace AppBundle\Service\Interfaces;

interface IHero
{
    public function getLevel(): int;

    public function setLevel(int $level);

    public function getExperience(): int;

    public function setExperience(int $experience);

    public function getHealth(): float;

    public function setHealth(int $currentHealth);
}
