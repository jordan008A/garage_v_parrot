<?php

namespace App\Entity;

use App\Repository\CarsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV6 as Uuid;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CarsRepository::class)]
#[ORM\Table(name: "cars")]
class Cars
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id;

    #[Assert\NotBlank()]
    #[ORM\Column(length: 50)]
    private ?string $title;

    #[Assert\NotNull()]
    #[ORM\Column]
    private ?int $price;

    #[Assert\NotBlank()]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $year;

    #[Assert\NotNull()]
    #[ORM\Column]
    private ?int $mileage;

    #[Assert\NotNull()]
    #[ORM\Column]
    private ?int $puissance_din;

    #[Assert\NotNull()]
    #[ORM\Column]
    private ?int $puissance_fiscale;

    #[Assert\NotNull()]
    #[ORM\Column]
    private ?bool $isAutomatically;

    #[ORM\ManyToOne(targetEntity: MotorTechnologies::class)]
    #[ORM\JoinColumn(name: "motor_technologie", referencedColumnName: "id")]
    private ?MotorTechnologies $motorTechnologie = null;

    #[ORM\ManyToOne(targetEntity: Brands::class)]
    #[ORM\JoinColumn(name: "brand", referencedColumnName: "id")]
    private ?Brands $brand = null;

    #[ORM\OneToMany(targetEntity: Pictures::class, mappedBy: "car")]
    private Collection $pictures;

    #[ORM\OneToMany(targetEntity: Messages::class, mappedBy: "car")]
    private Collection $messages;

    public function __construct()
    {
        $this->pictures = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?Uuid
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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getYear(): ?\DateTimeInterface
    {
        return $this->year;
    }

    public function setYear(\DateTimeInterface $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getMileage(): ?int
    {
        return $this->mileage;
    }

    public function setMileage(int $mileage): static
    {
        $this->mileage = $mileage;

        return $this;
    }

    public function getPuissanceDin(): ?int
    {
        return $this->puissance_din;
    }

    public function setPuissanceDin(int $puissance_din): static
    {
        $this->puissance_din = $puissance_din;

        return $this;
    }

    public function getPuissanceFiscale(): ?int
    {
        return $this->puissance_fiscale;
    }

    public function setPuissanceFiscale(int $puissance_fiscale): static
    {
        $this->puissance_fiscale = $puissance_fiscale;

        return $this;
    }

    public function isAutomatically(): ?bool
    {
        return $this->isAutomatically;
    }

    public function setAutomatically(bool $isAutomatically): static
    {
        $this->isAutomatically = $isAutomatically;

        return $this;
    }

    public function getMotorTechnologie(): ?MotorTechnologies
    {
        return $this->motorTechnologie;
    }

    public function setMotorTechnologie(?MotorTechnologies $motorTechnologie): static
    {
        $this->motorTechnologie = $motorTechnologie;

        return $this;
    }

    public function getBrand(): ?Brands
    {
        return $this->brand;
    }

    public function setBrand(?Brands $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    // Méthodes pour ajouter une image à la voiture
    public function addPicture(Pictures $picture): self
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures[] = $picture;
            $picture->setCar($this);
        }

        return $this;
    }

    // Méthodes pour retirer une image de la voiture
    public function removePicture(Pictures $picture): self
    {
        if ($this->pictures->removeElement($picture)) {
            if ($picture->getCar() === $this) {
                $picture->setCar(null);
            }
        }

        return $this;
    }

    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addMessage(Messages $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setCar($this);
        }

        return $this;
    }

    public function removeMessage(Messages $message): self
    {
        if ($this->messages->removeElement($message)) {
            if ($message->getCar() === $this) {
                $message->setCar(null);
            }
        }

        return $this;
    }

    public function getMessages(): Collection
    {
        return $this->messages;
    }
}
