<?php

namespace App\Entity;

use App\Repository\ReviewsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReviewsRepository::class)]
#[ORM\Table(name: "reviews")]
class Reviews
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
    #[ORM\Column(length: 175)]
    private ?string $text;

    #[Assert\NotNull()]
    #[Assert\Range(
        min: 1,
        max: 5,
    )]
    #[ORM\Column]
    private ?int $rate;

    #[Assert\NotNull()]
    #[ORM\ManyToOne(targetEntity: Services::class)]
    #[ORM\JoinColumn(name: "service_id", referencedColumnName: "id")]
    private ?Services $service;

    #[Assert\NotNull()]
    #[ORM\Column]
    private ?bool $approved = false;

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

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getRate(): ?int
    {
        return $this->rate;
    }

    public function setRate(int $rate): static
    {
        $this->rate = $rate;

        return $this;
    }

    public function getService(): ?Services
    {
        return $this->service;
    }

    public function setService(?Services $service): static
    {
        $this->service = $service;

        return $this;
    }

    public function isApproved(): ?bool
    {
        return $this->approved;
    }

    public function setApproved(bool $approved): static
    {
        $this->approved = $approved;

        return $this;
    }
}