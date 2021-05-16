<?php

declare(strict_types=1);

namespace App\Helper;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use RuntimeException;

class EntityManagerHelper
{
    public static function ensureManager(ObjectManager $manager): EntityManagerInterface
    {
        if (!$manager instanceof EntityManagerInterface) {
            throw new RuntimeException();
        }

        if (false === $manager->getConnection()->ping() || !$manager->isOpen()) {
            $manager->getConnection()->close();
            $manager->getConnection()->connect();
        }

        return $manager;
    }
}
