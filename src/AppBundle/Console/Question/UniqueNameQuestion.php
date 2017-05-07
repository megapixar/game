<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 04/05/2017
 * Time: 23:12
 */

namespace AppBundle\Console\Question;


use Doctrine\ORM\EntityRepository;
use Symfony\Component\Console\Question\Question;

class UniqueNameQuestion extends Question
{
    protected $em;
    protected $repository;

    public function __construct(
        $question,
        $default = true,
        EntityRepository $repository
    ) {
        parent::__construct($question, (bool)$default);

        $this->repository = $repository;

        $this->setNormalizer($this->getDefaultNormalizer());

        $this->setValidator($this->getDefaultValidator());
    }

    /**
     * Returns the default answer normalizer.
     *
     * @return callable
     */
    private function getDefaultNormalizer()
    {
        $default = $this->getDefault();

        return function ($answer) use ($default) {
            return $answer ? trim($answer) : $default;
        };
    }

    /**
     * Returns the default answer normalizer.
     *
     * @return callable
     */
    private function getDefaultValidator()
    {
        return function ($name) {

            $entity = $this->repository->findOneBy(['name' => $name]);

            if ($entity) {
                throw new \RuntimeException(
                    'The name of hero has to be unique!'
                );
            }

            return $name;
        };
    }
}