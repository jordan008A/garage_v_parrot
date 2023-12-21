<?php

namespace App\Entity;

use App\Repository\MessagesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;

#[ORM\Entity(repositoryClass: MessagesRepository::class)]
#[ORM\Table(name: "messages")]
class Messages
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[Assert\NotBlank()]
    #[ORM\Column(length: 50)]
    private ?string $firstname;

    #[Assert\NotBlank()]
    #[ORM\Column(length: 50)]
    private ?string $lastname;

    #[Assert\NotBlank()]
    #[Assert\Email(
        message: 'L\'email {{ value }} est invalide.',
    )]
    #[ORM\Column(length: 255)]
    private ?string $email;

    #[Assert\NotBlank()]
    #[AssertPhoneNumber(
        message: 'Le numéro de téléphone {{ value }} est invalide.',
        defaultRegion: 'FR',
    )]
    #[ORM\Column(length: 20)]
    private ?string $phone_number;

    #[Assert\NotBlank()]
    #[ORM\Column(length: 255)]
    private ?string $text;

    #[ORM\ManyToOne(targetEntity: Services::class, inversedBy: "messages")]
    private ?Services $service = null;

    #[ORM\ManyToOne(targetEntity: Cars::class, inversedBy: "messages")]
    private ?Cars $car = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(string $phone_number): static
    {
        $this->phone_number = $phone_number;

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

    public function getService(): ?Services
{
    return $this->service;
}

public function setService(?Services $service): self
{
    $this->service = $service;

    return $this;
}

    public function getCar(): ?Cars
    {
        return $this->car;
    }

    public function setCar(?Cars $car): self
    {
        $this->car = $car;

        return $this;
    }
}
