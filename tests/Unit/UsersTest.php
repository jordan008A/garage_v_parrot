<?php

namespace App\Tests\Unit;

use App\Entity\Users;
use App\Entity\Schedules;
use App\Entity\Reviews;
use App\Entity\Services;
use App\Entity\Cars;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UsersTest extends KernelTestCase
{
  private function createUser(): Users
  {
    return new Users();
  }

  public function testSetAndGetEmail(): void
  {
    $user = $this->createUser();
    $email = 'user@example.com';
    $user->setEmail($email);
    $this->assertSame($email, $user->getEmail());
  }

  public function testSetAndGetPassword(): void
  {
    $user = $this->createUser();
    $password = 'securepassword';
    $user->setPassword($password);
    $this->assertSame($password, $user->getPassword());
  }

  public function testSetAndGetFirstname(): void
  {
    $user = $this->createUser();
    $firstname = 'John';
    $user->setFirstname($firstname);
    $this->assertSame($firstname, $user->getFirstname());
  }

  public function testSetAndGetLastname(): void
  {
    $user = $this->createUser();
    $lastname = 'Doe';
    $user->setLastname($lastname);
    $this->assertSame($lastname, $user->getLastname());
  }

  public function testSetAndGetIsAdmin(): void
  {
    $user = $this->createUser();
    $user->setIsAdmin(true);
    $this->assertTrue($user->isIsAdmin());
  }

  public function testValidationForBlankEmail(): void
  {
    $this->performValidationTest('', 'setEmail', 'Email should not be blank');
  }

  public function testValidationForInvalidEmail(): void
  {
    $this->performValidationTest('invalid_email', 'setEmail', 'Email should be valid');
  }

  public function testValidationForBlankFirstname(): void
  {
    $this->performValidationTest('', 'setFirstname', 'Firstname should not be blank');
  }

  public function testValidationForBlankLastname(): void
  {
    $this->performValidationTest('', 'setLastname', 'Lastname should not be blank');
  }

  private function performValidationTest($value, $method, $message): void
  {
    self::bootKernel();
    $container = static::getContainer();

    $user = $this->createUser();
    $user->{$method}($value);

    $errors = $container->get('validator')->validate($user);
    $this->assertGreaterThan(0, count($errors), $message);
  }

  public function testAddAndRemoveSchedule(): void
  {
    $user = $this->createUser();
    $schedule = new Schedules();

    $user->addSchedule($schedule);
    $this->assertCount(1, $user->getSchedules());
    $this->assertTrue($user->getSchedules()->contains($schedule));
  
    $user->removeSchedule($schedule);
    $this->assertCount(0, $user->getSchedules());
  }
  
  public function testAddAndRemoveReview(): void
  {
    $user = $this->createUser();
    $review = new Reviews();

    $user->addReview($review);
    $this->assertCount(1, $user->getReviews());
    $this->assertTrue($user->getReviews()->contains($review));

    $user->removeReview($review);
    $this->assertCount(0, $user->getReviews());
  }
  
  public function testAddAndRemoveService(): void
  {
    $user = $this->createUser();
    $service = new Services();

    $user->addService($service);
    $this->assertCount(1, $user->getServices());
    $this->assertTrue($user->getServices()->contains($service));

    $user->removeService($service);
    $this->assertCount(0, $user->getServices());
  }

  public function testAddAndRemoveCar(): void
  {
    $user = $this->createUser();
    $car = new Cars();

    $user->addCar($car);
    $this->assertCount(1, $user->getCars());
    $this->assertTrue($user->getCars()->contains($car));

    $user->removeCar($car);
    $this->assertCount(0, $user->getCars());
  }

  public function testGetRoles(): void
  {
    $user = $this->createUser();
    $this->assertContains('ROLE_USER', $user->getRoles());

    $user->setIsAdmin(true);
    $this->assertContains('ROLE_ADMIN', $user->getRoles());
  }

  public function testGetUserIdentifier(): void
  {
    $user = $this->createUser();
    $email = 'user@example.com';
    $user->setEmail($email);

    $this->assertSame($email, $user->getUserIdentifier());
  }

  public function testSetAndGetResetToken(): void
  {
    $user = $this->createUser();
    $token = 'reset-token';
    $user->setResetToken($token);

    $this->assertSame($token, $user->getResetToken());
  }

  public function testSetAndGetResetTokenExpiresAt(): void
  {
    $user = $this->createUser();
    $date = new \DateTime('+1 hour');
    $user->setResetTokenExpiresAt($date);

    $this->assertSame($date, $user->getResetTokenExpiresAt());
  }
}
