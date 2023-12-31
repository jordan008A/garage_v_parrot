<?php

namespace App\Tests\Unit;

use App\Entity\Cars;
use App\Entity\Brands;
use App\Entity\Messages;
use App\Entity\Pictures;
use App\Entity\MotorTechnologies;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CarsTest extends KernelTestCase
{
  private function createCar(): Cars
  {
    return new Cars();
  }

  public function testSetTitleAndGetTitle(): void
  {
    $car = $this->createCar();
    $title = 'Car Title';
    $car->setTitle($title);
    $this->assertSame($title, $car->getTitle());
  }

  public function testSetPriceAndGetPrice(): void
  {
    $car = $this->createCar();
    $price = 10000;
    $car->setPrice($price);
    $this->assertSame($price, $car->getPrice());
  }

  public function testSetYearAndGetYear(): void
  {
    $car = $this->createCar();
    $year = '2023';
    $car->setYear($year);
    $this->assertSame($year, $car->getYear());
  }

  public function testSetMileageAndGetMileage(): void
  {
    $car = $this->createCar();
    $mileage = 50000;
    $car->setMileage($mileage);
    $this->assertSame($mileage, $car->getMileage());
  }

  public function testSetPuissanceDinAndGetPuissanceDin(): void
  {
    $car = $this->createCar();
    $puissance_din = 500;
    $car->setPuissanceDin($puissance_din);
    $this->assertSame($puissance_din, $car->getPuissanceDin());
  }

  public function testSetPuissanceFiscaleAndGetPuissanceFiscale(): void
  {
    $car = $this->createCar();
    $puissance_Fiscale = 50;
    $car->setPuissanceFiscale($puissance_Fiscale);
    $this->assertSame($puissance_Fiscale, $car->getPuissanceFiscale());
  }

  public function testIsAutomaticallyAndSetIsAutomatically(): void
  {
    $car = $this->createCar();
    $isautomatically = true;
    $car->setAutomatically($isautomatically);
    $this->assertSame($isautomatically, $car->isAutomatically());
  }

  public function testSetAndGetMotorTechnologie(): void
  {
    $car = $this->createCar();
    $motorTechnologie = new MotorTechnologies();
    $car->setMotorTechnologie($motorTechnologie);

    $this->assertSame($motorTechnologie, $car->getMotorTechnologie());
  }

  public function testSetAndGetBrand(): void
  {
    $car = $this->createCar();
    $brand = new Brands();
    $car->setBrand($brand);

    $this->assertSame($brand, $car->getBrand());
  }

  public function testAddAndRemovePicture(): void
  {
    $car = $this->createCar();
    $picture = new Pictures();
    $picture->setCar($car);
    $car->addPicture($picture);

    $this->assertCount(1, $car->getPictures());
    $this->assertTrue($car->getPictures()->contains($picture));

    $car->removePicture($picture);
    $this->assertCount(0, $car->getPictures());
  }

  public function testAddAndRemoveMessage(): void
  {
    $car = $this->createCar();
    $message = new Messages();
    $message->setCar($car);
    $car->addMessage($message);

    $this->assertCount(1, $car->getMessages());
    $this->assertTrue($car->getMessages()->contains($message));

    $car->removeMessage($message);
    $this->assertCount(0, $car->getMessages());
  }

  public function testTitleCannotBeBlank(): void
  {
    self::bootKernel();
    $container = static::getContainer();

    $car = $this->createCar();
    $car->setTitle('');
    $errors = $container->get('validator')->validate($car);
    $this->assertGreaterThan(0, count($errors));
  }

  public function testInvalidYearConstraint(): void
  {
    self::bootKernel();
    $container = static::getContainer();

    $car = $this->createCar();
    $car->setYear('abcd');
    $errors = $container->get('validator')->validate($car);
    $this->assertGreaterThan(0, count($errors));
  }

  public function testInvalidPriceConstraint(): void
  {
    self::bootKernel();
    $container = static::getContainer();

    $car = $this->createCar();
    $car->setPrice(-100);
    $errors = $container->get('validator')->validate($car);
    $this->assertGreaterThan(0, count($errors));
  }

  public function testInvalidMileageConstraint(): void
  {
    self::bootKernel();
    $container = static::getContainer();

    $car = $this->createCar();
    $car->setMileage(-1);
    $errors = $container->get('validator')->validate($car);
    $this->assertGreaterThan(0, count($errors));
  }

  public function testInvalidPuissanceDinConstraint(): void
  {
    self::bootKernel();
    $container = static::getContainer();

    $car = $this->createCar();
    $car->setPuissanceDin(-1);
    $errors = $container->get('validator')->validate($car);
    $this->assertGreaterThan(0, count($errors));
  }

  public function testInvalidPuissanceFiscaleConstraint(): void
  {
    self::bootKernel();
    $container = static::getContainer();

    $car = $this->createCar();
    $car->setPuissanceFiscale(-1);
    $errors = $container->get('validator')->validate($car);
    $this->assertGreaterThan(0, count($errors));
  }

}
