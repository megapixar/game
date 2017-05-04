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

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $manaPoints;

    /**
     * @return int
     */
    public function getManaPoints(): int
    {
        return $this->manaPoints;
    }

    /**
     * @param int $manaPoints
     */
    public function setManaPoints(int $manaPoints)
    {
        $this->manaPoints = $manaPoints;
    }
}

