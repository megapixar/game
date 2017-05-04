<?php

namespace AppBundle\Utils;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Question\Question;

class GameQuestion
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getNameQuestion()
    {
        $questionName = new Question('Please enter the name of your hero, name has to be unique: ', 'Batman');
        $questionName->setNormalizer(function ($value) {
            // $value can be null here
            return $value ? trim($value) : '';
        });

        $questionName->setValidator(function ($answer) {
            if (!is_string($answer) || 'Bundle' !== substr($answer, -6)) {
                throw new \RuntimeException(
                    'The name of the bundle should be suffixed with \'Bundle\''
                );
            }

            return $answer;
        });
    }
}