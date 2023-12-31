<?php

namespace App\Tests\Unit;

use App\Entity\Reviews;
use App\Entity\Services;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ReviewsTest extends KernelTestCase
{
  private function createReview(): Reviews
  {
    return new Reviews();
  }

  public function testSetAndGetFirstname(): void
  {
    $review = $this->createReview();
    $firstname = 'John';
    $review->setFirstname($firstname);
    $this->assertSame($firstname, $review->getFirstname());
  }

  public function testSetAndGetLastname(): void
  {
    $review = $this->createReview();
    $lastname = 'Doe';
    $review->setLastname($lastname);
    $this->assertSame($lastname, $review->getLastname());
  }

  public function testSetAndGetText(): void
  {
    $review = $this->createReview();
    $text = 'This is a review text.';
    $review->setText($text);
    $this->assertSame($text, $review->getText());
  }

  public function testSetAndGetRate(): void
  {
    $review = $this->createReview();
    $rate = 5;
    $review->setRate($rate);
    $this->assertSame($rate, $review->getRate());
  }

  public function testSetAndGetService(): void
  {
    $review = $this->createReview();
    $service = new Services();
    $review->setService($service);
    $this->assertSame($service, $review->getService());
  }

  public function testSetAndGetApproved(): void
  {
    $review = $this->createReview();
    $approved = true;
    $review->setApproved($approved);
    $this->assertSame($approved, $review->isApproved());
  }

  public function testValidationForBlankFirstname(): void
  {
    $this->performValidationTest('', 'setFirstname');
  }

  public function testValidationForBlankLastname(): void
  {
    $this->performValidationTest('', 'setLastname');
  }

  public function testValidationForBlankText(): void
  {
    $this->performValidationTest('', 'setText');
  }

  public function testValidationForInvalidRate(): void
  {
    $this->performValidationTest(6, 'setRate');
  }

  private function performValidationTest($value, $method): void
  {
    self::bootKernel();
    $container = static::getContainer();

    $review = $this->createReview();
    $review->{$method}($value);

    $errors = $container->get('validator')->validate($review);
    $this->assertGreaterThan(0, count($errors));
  }

}
