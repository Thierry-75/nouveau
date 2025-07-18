<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    public function __construct(private readonly UserPasswordHasherInterface $userPasswordHasher)
    { }

    /**
     * @param ObjectManager $manager
     * @throws \Exception
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
                    ->setPhone(random_int(0,1)=== 1 ? $faker->phoneNumber():' ')
                    ->setIsVerified(true)
                    ->setIsNewsLetter(true)
                    ->setPortrait('default.jpg');

            $manager->persist($user);
        }

        for($j=0; $j < 5; $j++)
        {
            $redactor = new User();
            $redactor->setEmail($faker->email())
                ->setRoles(['ROLE_REDACTOR'])
                ->setCreatedAt(new \DateTimeImmutable())
                ->setLogin(mt_rand(0,1)===1 ? $faker->firstNameFemale().' '.$faker->lastName() : $faker->firstNameMale() . ' ' . $faker->lastName())
                ->setPassword($this->userPasswordHasher->hashPassword($user,'ArethiA75!'))
                ->setPhone(random_int(0,1)=== 1 ? $faker->phoneNumber():' ')
                ->setIsVerified(true)
                ->setIsNewsLetter(true)
                ->setPortrait('default2.jpg');

            $manager->persist($redactor);

        }
        $manager->flush();
    }
}
