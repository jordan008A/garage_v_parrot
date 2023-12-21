<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MotorTechnologiesRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[UniqueEntity('property')]
#[ORM\Entity(repositoryClass: MotorTechnologiesRepository::class)]
#[ORM\Table(name: "motor_technologies")]
class MotorTechnologies
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[Assert\NotBlank()]
    #[ORM\Column(length: 30)]
    private ?string $property;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProperty(): ?string
    {
        return $this->property;
    }

    public function setProperty(string $property): static
    {
        $this->property = $property;

        return $this;
    }
}
