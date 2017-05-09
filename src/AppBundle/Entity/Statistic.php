<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Statistic
 *
 * @ORM\Table(name="statistic")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StatisticRepository")
 */
class Statistic
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="enemyType", type="string", length=255)
     */
    private $enemyType;

    /**
     * @var bool
     *
     * @ORM\Column(name="isWin", type="boolean")
     */
    private $isWin = false;

    /**
     * Many Features have One Product.
     * @ORM\ManyToOne(targetEntity="Hero", inversedBy="statistics")
     */
    private $hero;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get enemyType
     *
     * @return string
     */
    public function getEnemyType()
    {
        return $this->enemyType;
    }

    /**
     * Set enemyType
     *
     * @param string $enemyType
     *
     * @return Statistic
     */
    public function setEnemyType($enemyType)
    {
        $this->enemyType = $enemyType;

        return $this;
    }

    /**
     * Get isWin
     *
     * @return bool
     */
    public function getIsWin()
    {
        return $this->isWin;
    }

    /**
     * Set isWin
     *
     * @param boolean $isWin
     *
     * @return Statistic
     */
    public function setIsWin($isWin)
    {
        $this->isWin = $isWin;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHero()
    {
        return $this->hero;
    }

    /**
     * @param mixed $hero
     */
    public function setHero(Hero $hero)
    {
        $this->hero = $hero;
    }
}

