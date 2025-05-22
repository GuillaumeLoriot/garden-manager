<?php

namespace App\EventListener;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsEntityListener(event: Events::prePersist, method: 'hashPassword', entity: User::class)]
class HashUserPasswordListener
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {
    }

    public function hashPassword(User $user, PrePersistEventArgs $args): void
    {
        $user->setPassword($this->hasher->hashPassword($user, $user->getPassword()));
    }
}