<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class Warrior extends Hero
{
    /**
     * @var string
     */
    protected $discr = 'warrior';

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $armorPoints;
}

