<?php

namespace App\Tests\Unit;

use App\Entity\MotorTechnologies;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MotorTechnologiesTest extends KernelTestCase
{
  private function createMotorTechnologie(): MotorTechnologies
  {
    return new MotorTechnologies();
  }

  public function testSetAndGetProperty(): void
  {
    $motorTechnologie = $this->createMotorTechnologie();
    $property = 'Hybrid';
    $motorTechnologie->setProperty($property);
    $this->assertSame($property, $motorTechnologie->getProperty());
  }

  public function testPropertyCannotBeBlank(): void
  {
    self::bootKernel();
    $container = static::getContainer();

    $motorTechnologie = $this->createMotorTechnologie();
    $motorTechnologie->setProperty('');

    $errors = $container->get('validator')->validate($motorTechnologie);
    $this->assertGreaterThan(0, count($errors), 'Property should not be blank');
  }

  public function testPropertyExceedsMaxLength(): void
  {
    self::bootKernel();
    $container = static::getContainer();

    $motorTechnologie = $this->createMotorTechnologie();
    $longProperty = str_repeat('a', 31);
    $motorTechnologie->setProperty($longProperty);

    $errors = $container->get('validator')->validate($motorTechnologie);
    $this->assertGreaterThan(0, count($errors), 'Property should not exceed 30 characters');
  }
}