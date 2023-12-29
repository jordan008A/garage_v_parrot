<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Users;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $adminUser = new Users();
        $adminUser->setEmail('vincent@parrot.fr');
        $adminUser->setFirstname('Vincent');
        $adminUser->setLastname('Parrot');
        $adminUser->setIsAdmin(true);

        $hashedPassword = $this->passwordHasher->hashPassword(
            $adminUser,
            'studi2023'
        );

        $adminUser->setPassword($hashedPassword);

        $manager->persist($adminUser);
        $manager->flush();
    }
}
