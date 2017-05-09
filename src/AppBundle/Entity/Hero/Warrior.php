<?php

namespace AppBundle\Entity\Hero;

use AppBundle\Entity\Hero;
use AppBundle\Service\Interfaces\IHero;
use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class Warrior extends Hero implements IHero
{
    /**
     * @var string
     */
    protected $discr = 'warrior';

    protected $type = 'Warrior';
}

