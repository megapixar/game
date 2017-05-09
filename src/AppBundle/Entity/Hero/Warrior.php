<?php

namespace AppBundle\Entity\Hero;

use AppBundle\Entity\Hero;
use AppBundle\Service\Interfaces\IHero;
use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class Warrior extends Hero implements IHero
{
    protected $type = 'Warrior';
}

