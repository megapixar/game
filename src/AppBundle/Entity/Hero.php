<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Hero
 *
 * @ORM\Table(name="hero")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HeroRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"magician" = "Magician", "warrior" = "Warrior", "archer" = "Archer"})
 *
 * @UniqueEntity("name")
 */
abstract class Hero
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false, unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 3,
     *      minMessage = "Your name must be at least {{ limit }} characters long",
     * )
     */
    protected $name;
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $healthPoints = 100;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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
}

