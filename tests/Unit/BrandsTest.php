<?php

namespace App\Tests\Unit;

use App\Entity\Brands;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BrandsTest extends KernelTestCase
{
  private function createBrand(string $property = null): Brands
  {
    $brand = new Brands();
    if ($property !== null) {
      $brand->setProperty($property);
    }
    return $brand;
  }

  public function testEntityIsValid(): void
  {
    self::bootKernel();
    $container = static::getContainer();

    $brand = $this->createBrand('Property #1');

    $errors = $container->get('validator')->validate($brand);

    $this->assertCount(0, $errors);
  }

  public function testEntityIsInvalidWhenPropertyIsBlank(): void
  {
    self::bootKernel();
    $container = static::getContainer();

    $brand = $this->createBrand('');

    $errors = $container->get('validator')->validate($brand);

    $this->assertCount(1, $errors);
  }
  
  public function testGetProperty(): void
  {
    $propertyValue = 'Test Property';
    $brand = $this->createBrand($propertyValue);

    $this->assertSame($propertyValue, $brand->getProperty(), 'Getter for property should return what was set');
  }
}
