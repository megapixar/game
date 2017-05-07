<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class Archer extends Hero
{
    /**
     * @var string
     */
    protected $discr = 'magician';

}

