<?php

namespace App\DataFixtures;

use App\Entity\Cars;
use App\Entity\Brands;
use App\Entity\Reviews;
use App\Entity\Pictures;
use App\Entity\Services;
use App\Entity\Schedules;
use App\Entity\MotorTechnologies;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $technologies = ['Essence', 'Diesel', 'Électrique', 'Hybride', 'GPL', 'Éthanol', 'Autres'];

        foreach ($technologies as $tech) {
            $motorTech = new MotorTechnologies();
            $motorTech->setProperty($tech);
            $manager->persist($motorTech);
        }

        $brandProperty = [
            'Acura',
            'Alfa Romeo',
            'Aston Martin',
            'Audi',
            'Bentley',
            'BMW',
            'Bugatti',
            'Buick',
            'Cadillac',
            'Chery',
            'Chevrolet',
            'Chrysler',
            'Citroën',
            'Dacia',
            'Daewoo',
            'Daihatsu',
            'Dodge',
            'Ferrari',
            'Fiat',
            'Ford',
            'Geely',
            'Genesis',
            'GMC',
            'Great Wall',
            'Haval',
            'Honda',
            'Hummer',
            'Hyundai',
            'Infiniti',
            'Isuzu',
            'Jaguar',
            'Jeep',
            'Kia',
            'Lada',
            'Lamborghini',
            'Lancia',
            'Land Rover',
            'Lexus',
            'Lincoln',
            'Lotus',
            'Maserati',
            'Mazda',
            'McLaren',
            'Mercedes-Benz',
            'Mercury',
            'MG',
            'Mini',
            'Mitsubishi',
            'Nissan',
            'Opel',
            'Pagani',
            'Peugeot',
            'Pontiac',
            'Porsche',
            'Proton',
            'Ram',
            'Renault',
            'Rolls-Royce',
            'Saab',
            'Saturn',
            'Škoda',
            'Smart',
            'SsangYong',
            'Subaru',
            'Suzuki',
            'Tata',
            'Tesla',
            'Toyota',
            'Vauxhall',
            'Volkswagen',
            'Volvo',
            'Autres',
            'ZAZ'
        ];
        
        foreach ($brandProperty as $property) {
            $brand = new Brands();
            $brand->setProperty($property);
            $manager->persist($brand);
        }

        $manager->flush();

        $essence = $manager->getRepository(MotorTechnologies::class)->findOneBy(['property' => 'Essence']);
        $hybride = $manager->getRepository(MotorTechnologies::class)->findOneBy(['property' => 'Hybride']);
        $diesel = $manager->getRepository(MotorTechnologies::class)->findOneBy(['property' => 'Diesel']);

        $volkswagen = $manager->getRepository(Brands::class)->findOneBy(['property' => 'Volkswagen']);
        $fiat = $manager->getRepository(Brands::class)->findOneBy(['property' => 'Fiat']);
        $volvo = $manager->getRepository(Brands::class)->findOneBy(['property' => 'Volvo']);
        $bugatti = $manager->getRepository(Brands::class)->findOneBy(['property' => 'Bugatti']);
        $mercedes = $manager->getRepository(Brands::class)->findOneBy(['property' => 'Mercedes-Benz']);
        $chevrolet = $manager->getRepository(Brands::class)->findOneBy(['property' => 'Chevrolet']);

        $cars = [];
        $carsData = [
            [
                'title' => 'Golf VII GTI',
                'price' => 27000,
                'year' => 2019,
                'mileage' => 42000,
                'puissanceDin' => 245,
                'puissanceFiscale' => 14,
                'automatically' => 1,
                'motorTech' => $essence,
                'brand' => $volkswagen
            ],
            [
                'title' => 'Fiat 500',
                'price' => 13000,
                'year' => 1992,
                'mileage' => 134000,
                'puissanceDin' => 70,
                'puissanceFiscale' => 6,
                'automatically' => 0,
                'motorTech' => $diesel,
                'brand' => $fiat
            ],
            [
                'title' => 'Volvo XC90',
                'price' => 22000,
                'year' => 2016,
                'mileage' => 78000,
                'puissanceDin' => 300,
                'puissanceFiscale' => 16,
                'automatically' => 1,
                'motorTech' => $hybride,
                'brand' => $volvo
            ],
            [
                'title' => 'Bugatti Chiron',
                'price' => 2237000,
                'year' => 2022,
                'mileage' => 12000,
                'puissanceDin' => 1000,
                'puissanceFiscale' => 100,
                'automatically' => 0,
                'motorTech' => $essence,
                'brand' => $bugatti
            ],
            [
                'title' => 'AMG GTR',
                'price' => 246000,
                'year' => 2022,
                'mileage' => 23000,
                'puissanceDin' => 600,
                'puissanceFiscale' => 40,
                'automatically' => 0,
                'motorTech' => $essence,
                'brand' => $mercedes
            ],
            [
                'title' => 'Camaro',
                'price' => 32000,
                'year' => 2018,
                'mileage' => 56000,
                'puissanceDin' => 400,
                'puissanceFiscale' => 20,
                'automatically' => 0,
                'motorTech' => $diesel,
                'brand' => $chevrolet
            ]
        ];

        foreach ($carsData as $carData) {
            $car = new Cars();
            $car->setTitle($carData['title']);
            $car->setPrice($carData['price']);
            $car->setYear($carData['year']);
            $car->setMileage($carData['mileage']);
            $car->setPuissanceDin($carData['puissanceDin']);
            $car->setPuissanceFiscale($carData['puissanceFiscale']);
            $car->setAutomatically($carData['automatically']);
            $car->setMotorTechnologie($carData['motorTech']);
            $car->setBrand($carData['brand']);
            $manager->persist($car);
            $cars[] = $car;
        }
        $manager->flush();

        foreach ($cars as $index => $car) {
            $carNumber = $index + 1;
        
            $picture = new Pictures();
            $picture->setPicture("voiture-{$carNumber}-1.jpg");
            $picture->setCar($car);
            $picture->setIsPrimary(true);
            $manager->persist($picture);
        
            for ($j = 2; $j <= 4; $j++) {
                $picture = new Pictures();
                $picture->setPicture("voiture-{$carNumber}-{$j}.jpg");
                $picture->setCar($car);
                $picture->setIsPrimary(false);
                $manager->persist($picture);
            }
        }

        $schedulesData = [
            ['08:45 - 12:00 ; 13:30 - 17:15', 'Lundi'],
            ['08:45 - 12:00 ; 13:30 - 17:15', 'Mardi'],
            ['08:45 - 12:00 ; 13:30 - 17:15', 'Mercredi'],
            ['08:45 - 12:00 ; 13:30 - 17:15', 'Jeudi'],
            ['08:45 - 12:00 ; 13:30 - 17:15', 'Vendredi'],
            ['08:45 - 12:00', 'Samedi'],
            ['Fermé', 'Dimanche']
        ];

        foreach ($schedulesData as $data) {
            $schedule = new Schedules();
            $schedule->setText($data[0]);
            $schedule->setDay($data[1]);
            $manager->persist($schedule);
        }

        $servicesData = [
            ['Réparation de mécanique générale',
            'mecanique.jpg',
            'Notre garage offre une expertise pointue en réparations mécaniques, 
            résolvant efficacement les problèmes liés au moteur, à la transmission 
            et à d\'autres composants essentiels. Nous diagnostiquons avec précision 
            et réparons rapidement pour vous remettre sur la route en toute sécurité.'
            ],
            ['Entretien périodique', 
            'entretien.jpg',
            'Assurer la longévité de votre véhicule est notre priorité. 
            Notre service d\'entretien périodique comprend des vérifications rigoureuses, 
            des changements d\'huile réguliers et une maintenance préventive pour garantir 
            des performances optimales et réduire les risques de pannes inattendues.'
            ],
            ['Service de climatisation', 
            'climatisation.jpg',
            'La fraîcheur dans votre voiture est cruciale. Notre équipe spécialisée 
            offre un service complet de climatisation, du diagnostic des problèmes de refroidissement 
            à la réparation des fuites, assurant un confort optimal dans votre véhicule par tous les temps.'
            ],
            ['Réparation et remplacement des pneus', 
            'pneus.jpg',
            'Des pneus en bon état sont essentiels pour une conduite sûre. 
            Nous proposons des services de réparation de pneus crevés, 
            d\'alignement, et de remplacement, avec une gamme de marques et de modèles pour répondre 
            à vos besoins spécifiques.'
            ],
            ['Réparation de la carrosserie', 
            'carosserie.jpg',
            'Des bosses aux éraflures, notre équipe de réparation de carrosserie redonne 
            à votre véhicule son aspect d\'origine. Nous utilisons des techniques avancées pour 
            restaurer la carrosserie, vous offrant un résultat impeccable et une voiture qui brille 
            comme neuve.'
            ],
            ['Vente de véhicules d’occasions', 
            'occasion.jpg',
            'Notre garage se spécialise dans la vente de voitures d\'occasion de qualité. 
            Chaque véhicule est rigoureusement sélectionné et révisé par nos experts pour garantir 
            fiabilité et performance. Nous proposons un large choix de marques et modèles, 
            adaptés à tous les budgets et besoins. Notre équipe passionnée est à votre écoute 
            pour vous accompagner dans le choix de votre prochaine voiture.'],
        ];

        foreach ($servicesData as $data) {
            $service = new Services();
            $service->setTitle($data[0]);
            $service->setPicture($data[1]);
            $service->setText($data[2]);
            $manager->persist($service);
        }

        $manager->flush();

        $mecanique = $manager->getRepository(Services::class)->findOneBy(['title' => 'Réparation de mécanique générale']);
        $entretien = $manager->getRepository(Services::class)->findOneBy(['title' => 'Entretien périodique']);
        $climatisation = $manager->getRepository(Services::class)->findOneBy(['title' => 'Service de climatisation']);
        $pneus = $manager->getRepository(Services::class)->findOneBy(['title' => 'Réparation et remplacement des pneus']);
        $carosserie = $manager->getRepository(Services::class)->findOneBy(['title' => 'Réparation de la carrosserie']);
        $occasions = $manager->getRepository(Services::class)->findOneBy(['title' => 'Vente de véhicules d’occasions']);

        $reviewsData = [
            [
                'firstname' => 'John',
                'lastname' => 'Doe',
                'text' => 'Très satisfait de la réparation mécanique générale.',
                'rate' => 5,
                'service' => $mecanique,
                'approved' => true
            ],
            [
                'firstname' => 'Jane',
                'lastname' => 'Doe',
                'text' => 'L’entretien périodique était excellent.',
                'rate' => 4,
                'service' => $entretien,
                'approved' => true
            ],
            [
                'firstname' => 'Alex',
                'lastname' => 'Martin',
                'text' => 'Service de climatisation impeccable et rapide.',
                'rate' => 5,
                'service' => $climatisation,
                'approved' => true
            ],
            [
                'firstname' => 'Sophie',
                'lastname' => 'Leroy',
                'text' => 'Réparation de pneus professionnelle. Très satisfait.',
                'rate' => 4,
                'service' => $pneus,
                'approved' => true
            ],
            [
                'firstname' => 'Lucas',
                'lastname' => 'Dupont',
                'text' => 'Travail exceptionnel sur la carrosserie de ma voiture.',
                'rate' => 5,
                'service' => $carosserie,
                'approved' => true
            ],
            [
                'firstname' => 'Emma',
                'lastname' => 'Durand',
                'text' => 'Achat de voiture d’occasion très satisfaisant, service impeccable.',
                'rate' => 5,
                'service' => $occasions,
                'approved' => true
            ]
        ];
        
        foreach ($reviewsData as $data) {
            $review = new Reviews();
            $review->setFirstname($data['firstname']);
            $review->setLastname($data['lastname']);
            $review->setText($data['text']);
            $review->setRate($data['rate']);
            $review->setService($data['service']);
            $review->setApproved($data['approved']);
            $manager->persist($review);
        }
        
        $manager->flush();        
    }
}
