<?php

namespace App\Tests\Unit;

use App\Entity\Messages;
use App\Entity\Services;
use App\Entity\Cars;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MessagesTest extends KernelTestCase
{
  private function createMessage(): Messages
  {
    return new Messages();
  }

  public function testSetAndGetFirstname(): void
  {
    $message = $this->createMessage();
    $firstname = 'John';
    $message->setFirstname($firstname);
    $this->assertSame($firstname, $message->getFirstname());
  }

  public function testSetAndGetLastname(): void
  {
    $message = $this->createMessage();
    $lastname = 'Doe';
    $message->setLastname($lastname);
    $this->assertSame($lastname, $message->getLastname());
  }

  public function testSetAndGetEmail(): void
  {
    $message = $this->createMessage();
    $email = 'john.doe@example.com';
    $message->setEmail($email);
    $this->assertSame($email, $message->getEmail());
  }

  public function testSetAndGetPhoneNumber(): void
  {
    $message = $this->createMessage();
    $phone_number = '1234567890';
    $message->setPhoneNumber($phone_number);
    $this->assertSame($phone_number, $message->getPhoneNumber());
  }

  public function testSetAndGetText(): void
  {
    $message = $this->createMessage();
    $text = 'Hello, this is a test message.';
    $message->setText($text);
    $this->assertSame($text, $message->getText());
  }

  public function testSetAndGetService(): void
  {
    $message = $this->createMessage();
    $service = new Services();
    $message->setService($service);
    $this->assertSame($service, $message->getService());
  }

  public function testSetAndGetCar(): void
  {
    $message = $this->createMessage();
    $car = new Cars();
    $message->setCar($car);
    $this->assertSame($car, $message->getCar());
  }

  public function testValidationForBlankFirstname(): void
  {
    self::bootKernel();
    $container = static::getContainer();

    $message = $this->createMessage();
    $message->setFirstname('');

    $errors = $container->get('validator')->validate($message);
    $this->assertGreaterThan(0, count($errors));
  }

  public function testValidationForBlankLastname(): void
  {
    self::bootKernel();
    $container = static::getContainer();

    $message = $this->createMessage();
    $message->setLastname('');

    $errors = $container->get('validator')->validate($message);
    $this->assertGreaterThan(0, count($errors));
  }

  public function testValidationForInvalidEmail(): void
  {
    self::bootKernel();
    $container = static::getContainer();

    $message = $this->createMessage();
    $message->setEmail('invalid_email');

    $errors = $container->get('validator')->validate($message);
    $this->assertGreaterThan(0, count($errors));
  }

  public function testValidationForInvalidPhoneNumber(): void
  {
    self::bootKernel();
    $container = static::getContainer();

    $message = $this->createMessage();
    $message->setPhoneNumber('invalid_phone');

    $errors = $container->get('validator')->validate($message);
    $this->assertGreaterThan(0, count($errors));
  }

  public function testValidationForBlankText(): void
  {
    self::bootKernel();
    $container = static::getContainer();

    $message = $this->createMessage();
    $message->setText('');

    $errors = $container->get('validator')->validate($message);
    $this->assertGreaterThan(0, count($errors));
  }
}