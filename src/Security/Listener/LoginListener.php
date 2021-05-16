<?php

declare(strict_types=1);

namespace App\Security\Listener;

use App\Entity\User;
use App\Helper\EntityManagerHelper;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LoginListener
{
    private ManagerRegistry $registry;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event): void
    {
        /** @var User $user */
        $user = $event->getAuthenticationToken()->getUser();

        $user->setLastLogin(new \DateTimeImmutable('now'));

        $this->getManager()->flush();
    }

    private function getManager(): EntityManagerInterface
    {
        return EntityManagerHelper::ensureManager($this->registry->getManager());
    }
}
