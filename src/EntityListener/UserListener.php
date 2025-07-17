<?php

namespace App\EntityListener;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class UserListener
{

    public function __construct(private UserPasswordHasherInterface $hasher)
    {}

    public function encodePasswordUser(User $user): void
    {
        if($user->getPlainPassword() ===null) {
            return;
        }
        $user->setPassword($this->hasher->hashPassword($user,$user->getPlainPassword()));
        $user->setPlainPassword(' ');
    }

    public function prePersist(User $user): void
    {
        $this->encodePasswordUser($user);
    }

    public function preUpdate(User $user): void
    {
        $this->encodePasswordUser($user);
    }
}
