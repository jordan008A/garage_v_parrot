<?php

namespace App\DataFixtures;

use App\Entity\Cars;
use App\Entity\Brands;
use App\Entity\Pictures;
use App\Entity\MotorTechnologies;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CarFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $motorTech = new MotorTechnologies();
        $motorTech->setProperty('Extraterrestre');
        $manager->persist($motorTech);

        $brand = new Brands();
        $brand->setProperty('Alien');
        $manager->persist($brand);
        $manager->flush();


        $cars = [];
        for ($i = 0; $i < 5; $i++) {
            $car = new Cars();
            $car->setTitle('Car ' . $i);
            $car->setPrice(rand(2000, 150000));
            $car->setYear('202' . $i);
            $car->setMileage(rand(5000, 300000));
            $car->setPuissanceDin(rand(80, 1000));
            $car->setPuissanceFiscale(rand(6, 150));
            $car->setAutomatically(rand(0, 1));
            $car->setMotorTechnologie($motorTech);
            $car->setBrand($brand);
            $manager->persist($car);
            $cars[] = $car;
        }
        $manager->flush();

        foreach ($cars as $car) {
          $isPrimarySet = false;
          for ($j = 0; $j < 4; $j++) {
              $picture = new Pictures();
              $picture->setPicture('voiture-' . rand(1, 6) . '-' . rand(1, 4) . '.jpg');
              $picture->setCar($car);
      
              if (!$isPrimarySet && rand(0, 3) == 0) {
                  $picture->setIsPrimary(true);
                  $isPrimarySet = true;
              } else {
                  $picture->setIsPrimary(false);
              }
      
              $manager->persist($picture);
          }
      }
      $manager->flush();
    }
}
