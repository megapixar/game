<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Hero
 *
 * @ORM\Table(name="hero")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HeroRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 *     "magician" = "AppBundle\Entity\Hero\Magician",
 *     "warrior" = "AppBundle\Entity\Hero\Warrior",
 *     "archer" = "AppBundle\Entity\Hero\Archer"
 * })
 *
 * @UniqueEntity("name")
 */
abstract class Hero
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false, unique=true)
     *
     */
    protected $name;
    /**
     * One Product has Many Features.
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Statistic", mappedBy="hero", cascade={"persist"})
     */
    protected $statistics;
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $level = 1;
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $experience = 1;
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $health = 0;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Hero constructor.
     */
    public function __construct()
    {
        $this->statistics = new ArrayCollection();
    }

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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * @param int $level
     */
    public function setLevel(int $level)
    {
        $this->level = $level;
    }

    /**
     * @param $enemyType
     * @param $isWin
     */
    public function statistic($enemyType, $isWin)
    {
        $statistic = new Statistic();
        $statistic->setEnemyType($enemyType)
            ->setIsWin($isWin);
        $statistic->setHero($this);

        $this->statistics->add($statistic);
    }

    /**
     * @return []
     */
    public function getStatistics()
    {
        return $this->statistics;
    }

    /**
     * @return float
     */
    public function getHealth(): float
    {
        return $this->health;
    }

    /**
     * @param int $health
     */
    public function setHealth(int $health)
    {
        $this->health = $health;
    }

    /**
     * @return int
     */
    public function getExperience(): int
    {
        return $this->experience;
    }

    /**
     * @param int $experience
     */
    public function setExperience(int $experience)
    {
        $this->experience = $experience;
    }

    /**
     * @param int $experience
     */
    public function increaseExperience(int $experience)
    {
        $this->experience += $experience;
    }
}
