<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV7 as Uuid;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[ORM\Table(name: "users")]
class Users implements PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[Assert\NotBlank()]
    #[Assert\Email(
        message: 'L\'email {{ value }} est invalide.',
    )]
    #[ORM\Column(length: 255, unique:true)]
    private ?string $email = null;

    #[Assert\NotBlank()]
    #[ORM\Column(length: 60)]
    private ?string $password = null;

    #[Assert\NotBlank()]
    #[ORM\Column(length: 50)]
    private ?string $firstname = null;

    #[Assert\NotBlank()]
    #[ORM\Column(length: 50)]
    private ?string $lastname = null;

    #[Assert\NotBlank()]
    #[ORM\Column]
    private ?bool $isAdmin = false;

    #[ORM\ManyToMany(targetEntity: Schedules::class)]
    #[ORM\JoinTable(name: "schedules_users",
        joinColumns: [new ORM\JoinColumn(name: "user_id", referencedColumnName: "id")],
        inverseJoinColumns: [new ORM\JoinColumn(name: "schedule_id", referencedColumnName: "id")]
    )]
    private Collection $schedules;

    #[ORM\ManyToMany(targetEntity: Reviews::class)]
    #[ORM\JoinTable(name: "reviews_users",
        joinColumns: [new ORM\JoinColumn(name: "user_id", referencedColumnName: "id")],
        inverseJoinColumns: [new ORM\JoinColumn(name: "review_id", referencedColumnName: "id")]
    )]
    private Collection $reviews;

    #[ORM\ManyToMany(targetEntity: Services::class)]
    #[ORM\JoinTable(name: "services_users",
        joinColumns: [new ORM\JoinColumn(name: "user_id", referencedColumnName: "id")],
        inverseJoinColumns: [new ORM\JoinColumn(name: "service_id", referencedColumnName: "id")]
    )]
    private Collection $services;

    #[ORM\ManyToMany(targetEntity: Cars::class)]
    #[ORM\JoinTable(name: "cars_users",
        joinColumns: [new ORM\JoinColumn(name: "user_id", referencedColumnName: "id")],
        inverseJoinColumns: [new ORM\JoinColumn(name: "car_id", referencedColumnName: "id")]
    )]
    private Collection $cars;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $resetToken = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $resetTokenExpiresAt = null;

    public function __construct()
    {
        $this->schedules = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->services = new ArrayCollection();
        $this->cars = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
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

    public function isIsAdmin(): ?bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(bool $isAdmin): static
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    public function addSchedule(Schedules $schedule): self
    {
        if (!$this->schedules->contains($schedule)) {
            $this->schedules[] = $schedule;
        }

        return $this;
    }

    public function removeSchedule(Schedules $schedule): self
    {
        $this->schedules->removeElement($schedule);

        return $this;
    }

    public function addReview(Reviews $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
        }

        return $this;
    }

    public function removeReview(Reviews $review): self
    {
        $this->reviews->removeElement($review);

        return $this;
    }

    public function addService(Services $service): self
    {
        if (!$this->services->contains($service)) {
            $this->services[] = $service;
        }

        return $this;
    }

    public function removeService(Services $service): self
    {
        $this->services->removeElement($service);

        return $this;
    }

    public function addCar(Cars $car): self
    {
        if (!$this->cars->contains($car)) {
            $this->cars[] = $car;
        }

        return $this;
    }

    public function removeCar(Cars $car): self
    {
        $this->cars->removeElement($car);

        return $this;
    }

    public function getResetToken(): ?string
    {
        return $this->resetToken;
    }

    public function setResetToken(?string $resetToken): self
    {
        $this->resetToken = $resetToken;

        return $this;
    }

    public function getResetTokenExpiresAt(): ?\DateTimeInterface
    {
        return $this->resetTokenExpiresAt;
    }

    public function setResetTokenExpiresAt(?\DateTimeInterface $resetTokenExpiresAt): self
    {
        $this->resetTokenExpiresAt = $resetTokenExpiresAt;

        return $this;
    }
}
