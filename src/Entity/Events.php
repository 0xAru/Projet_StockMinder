<?php

namespace App\Entity;

use App\Repository\EventsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventsRepository::class)]
class Events
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Start_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $End_date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $Start_time = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $End_time = null;

    #[ORM\Column]
    private ?int $Display_time_period = null;

    #[ORM\Column(length: 255)]
    private ?string $Theme = null;

    #[ORM\Column(length: 500)]
    private ?string $Image = null;

    #[ORM\Column(length: 550)]
    private ?string $Description = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Companies $id_company = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->Start_date;
    }

    public function setStartDate(\DateTimeInterface $Start_date): static
    {
        $this->Start_date = $Start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->End_date;
    }

    public function setEndDate(\DateTimeInterface $End_date): static
    {
        $this->End_date = $End_date;

        return $this;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->Start_time;
    }

    public function setStartTime(\DateTimeInterface $Start_time): static
    {
        $this->Start_time = $Start_time;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->End_time;
    }

    public function setEndTime(\DateTimeInterface $End_time): static
    {
        $this->End_time = $End_time;

        return $this;
    }

    public function getDisplayTimePeriod(): ?int
    {
        return $this->Display_time_period;
    }

    public function setDisplayTimePeriod(int $Display_time_period): static
    {
        $this->Display_time_period = $Display_time_period;

        return $this;
    }

    public function getTheme(): ?string
    {
        return $this->Theme;
    }

    public function setTheme(string $Theme): static
    {
        $this->Theme = $Theme;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->Image;
    }

    public function setImage(string $Image): static
    {
        $this->Image = $Image;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function getIdCompany(): ?Companies
    {
        return $this->id_company;
    }

    public function setIdCompany(?Companies $id_company): static
    {
        $this->id_company = $id_company;

        return $this;
    }
}
