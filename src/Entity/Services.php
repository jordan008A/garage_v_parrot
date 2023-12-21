<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ServicesRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity('title')]
#[ORM\Entity(repositoryClass: ServicesRepository::class)]
#[ORM\Table(name: "services")]
class Services
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[Assert\NotBlank()]
    #[ORM\Column(length: 50)]
    private ?string $title;

    #[Assert\NotBlank()]
    #[ORM\Column(length: 255)]
    private ?string $text;

    #[Assert\NotBlank()]
    #[ORM\Column(length: 255)]
    private ?string $picture;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }
}