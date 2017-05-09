<?php

namespace AppBundle\Service\Enemy;

use AppBundle\Service\AbstractFighter;
use RuntimeException;

class EnemyStaticFactory
{
    public static $enemyTypes = ['wolf' => Wolf::class, 'zombie' => Zombie::class];

    /**
     * @param $type
     *
     * @return AbstractFighter
     */
    public static function create($type): AbstractFighter
    {
        if (empty(self::$enemyTypes[$type])) {
            throw new RuntimeException('Wrong enemy type');
        }

        return new self::$enemyTypes[$type];
    }

    /**
     * @return AbstractFighter
     */
    public static function createRandom(): AbstractFighter
    {
        $randomEnemy = self::$enemyTypes[array_rand(self::$enemyTypes)];

        return new $randomEnemy;
    }
}
