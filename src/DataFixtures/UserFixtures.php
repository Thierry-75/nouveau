<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Random\RandomException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    public function __construct(private readonly UserPasswordHasherInterface $userPasswordHasher)
    { }

    /**
     * @throws RandomException
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for($i=0; $i < 5; $i++)
        {
            $user = new User();
            $user->setEmail($faker->email())
                    ->setRoles(['ROLE_USER'])
                    ->setCreatedAt(new \DateTimeImmutable())
                    ->setLogin($faker->name())
                    ->setPassword($this->userPasswordHasher->hashPassword($user,'ArethiA75!'))
                    ->setPhone(random_int(0,1)=== 1 ? $faker->serviceNumber():' ')
                    ->setIsVerified(true)
                    ->setIsNewsLetter(true)
                    ->setPortrait('default.jpg');

            $manager->persist($user);
        }
        $manager->flush();
    }
}
