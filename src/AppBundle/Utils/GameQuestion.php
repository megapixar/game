<?php

namespace AppBundle\Utils;

use AppBundle\Entity\Hero;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GameQuestion
{
    protected $em;

    public function __construct(EntityManagerInterface $em, ValidatorInterface $validator)
    {
        $this->em = $em;
        $this->validator = $validator;
    }

    public function getNameQuestion()
    {
        $questionName = new Question('Please enter the name of your hero, name has to be unique: ', 'Batman');
        $questionName->setNormalizer(function ($value) {
            // $value can be null here
            return $value ? trim($value) : '';
        });

        $questionName->setValidator(function ($name) {

            return !$this->em->getRepository(Hero::class)
                ->findOneBy(['name' => $name]);
        });
    }
}