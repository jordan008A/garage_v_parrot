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
        $email = 'vincent@parrot.fr'; // Replace this email with yours
        $firstname = 'Vincent'; // Replace this firstname with yours
        $lastname = 'Parrot'; // Replace this lastname with yours
        $password = 'studi2023'; // Replace this password with yours

        $adminUser = new Users();
        $adminUser->setEmail($email);
        $adminUser->setFirstname($firstname);
        $adminUser->setLastname($lastname);
        $adminUser->setIsAdmin(true);

        $hashedPassword = $this->passwordHasher->hashPassword(
            $adminUser,
            $password
        );

        $adminUser->setPassword($hashedPassword);

        $manager->persist($adminUser);
        $manager->flush();
    }
}
