<?php

namespace AppBundle\Entity\Hero;

use AppBundle\Entity\Hero;
use AppBundle\Service\Interfaces\IHeroMagician;
use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class Magician extends Hero implements IHeroMagician
{
    protected $type = 'Magician';

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $mana = 0;

    /**
     * @return int
     */
    public function getMana(): int
    {
        return $this->mana;
    }

    /**
     * @param int $mana
     */
    public function setMana(int $mana)
    {
        $this->mana = $mana;
    }
}
