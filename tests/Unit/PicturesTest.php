<?php

namespace App\Tests\Unit;

use App\Entity\Pictures;
use App\Entity\Cars;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PicturesTest extends KernelTestCase
{
  private function createPicture(): Pictures
  {
    return new Pictures();
  }

  public function testSetAndGetPicture(): void
  {
    $picture = $this->createPicture();
    $imagePath = 'path/to/image.jpg';
    $picture->setPicture($imagePath);
    $this->assertSame($imagePath, $picture->getPicture());
  }

  public function testIsPrimaryFlag(): void
  {
    $picture = $this->createPicture();
    $this->assertFalse($picture->isIsPrimary(), 'By default, is_primary should be false');

    $picture->setIsPrimary(true);
    $this->assertTrue($picture->isIsPrimary(), 'is_primary should be true after setting it to true');
  }

  public function testDefaultIsPrimaryValue(): void
  {
    $picture = $this->createPicture();
    $this->assertFalse($picture->isIsPrimary(), 'is_primary should be false by default');
  }

  public function testSetAndGetCar(): void
  {
    $picture = $this->createPicture();
    $car = new Cars();
    $picture->setCar($car);
    $this->assertSame($car, $picture->getCar());
  }
}
