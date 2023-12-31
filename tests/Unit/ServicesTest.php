<?php

namespace App\Tests\Unit;

use App\Entity\Services;
use App\Entity\Messages;
use App\Entity\Reviews;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ServicesTest extends KernelTestCase
{
  private function createService(): Services
  {
    return new Services();
  }

  public function testSetAndGetTitle(): void
  {
    $service = $this->createService();
    $title = 'Service Title';
    $service->setTitle($title);
    $this->assertSame($title, $service->getTitle());
  }

  public function testSetAndGetText(): void
  {
    $service = $this->createService();
    $text = 'Service Description';
    $service->setText($text);
    $this->assertSame($text, $service->getText());
  }

  public function testSetAndGetPicture(): void
  {
    $service = $this->createService();
    $picture = 'path/to/picture.jpg';
    $service->setPicture($picture);
    $this->assertSame($picture, $service->getPicture());
  }

  public function testAddAndRemoveMessage(): void
  {
    $service = $this->createService();
    $message = new Messages();

    $service->addMessage($message);
    $this->assertCount(1, $service->getMessages());
    $this->assertTrue($service->getMessages()->contains($message));

    $service->removeMessage($message);
    $this->assertCount(0, $service->getMessages());
  }

  public function testAddAndRemoveReview(): void
  {
    $service = $this->createService();
    $review = new Reviews();

    $service->addReview($review);
    $this->assertCount(1, $service->getReviews());
    $this->assertTrue($service->getReviews()->contains($review));

    $service->removeReview($review);
    $this->assertCount(0, $service->getReviews());
  }

  public function testValidationForBlankTitle(): void
  {
    $this->performValidationTest('', 'setTitle', 'Title should not be blank');
  }

  public function testValidationForBlankText(): void
  {
    $this->performValidationTest('', 'setText', 'Text should not be blank');
  }

  public function testValidationForBlankPicture(): void
  {
    $this->performValidationTest('', 'setPicture', 'Picture should not be blank');
  }

  private function performValidationTest($value, $method, $message): void
  {
    self::bootKernel();
    $container = static::getContainer();

    $service = $this->createService();
    $service->{$method}($value);

    $errors = $container->get('validator')->validate($service);
    $this->assertGreaterThan(0, count($errors), $message);
  }
}
