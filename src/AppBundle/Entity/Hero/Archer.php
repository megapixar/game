<?php

namespace AppBundle\Entity\Hero;

use AppBundle\Entity\Hero;
use AppBundle\Service\Interfaces\IHeroArcher;
use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class Archer extends Hero implements IHeroArcher
{
    protected $type = 'Archer';

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $arrows = 0;

    /**
     * @return int
     */
    public function getArrows(): int
    {
        return $this->arrows;
    }

    /**
     * @param int $arrows
     */
    public function setArrows(int $arrows)
    {
        $this->arrows = $arrows;
    }
}
