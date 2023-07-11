<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $Lastname = null;

    #[ORM\Column]
    private ?int $User_position = null;

    #[ORM\Column]
    private ?int $Employee_number = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Password = null;

    #[ORM\ManyToOne(inversedBy: 'Id_user')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Companies $Id_company = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->Firstname;
    }

    public function setFirstname(string $Firstname): static
    {
        $this->Firstname = $Firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->Lastname;
    }

    public function setLastname(string $Lastname): static
    {
        $this->Lastname = $Lastname;

        return $this;
    }

    public function getUserPosition(): ?int
    {
        return $this->User_position;
    }

    public function setUserPosition(int $User_position): static
    {
        $this->User_position = $User_position;

        return $this;
    }

    public function getEmployeeNumber(): ?int
    {
        return $this->Employee_number;
    }

    public function setEmployeeNumber(int $Employee_number): static
    {
        $this->Employee_number = $Employee_number;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(?string $Email): static
    {
        $this->Email = $Email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->Password;
    }

    public function setPassword(?string $Password): static
    {
        $this->Password = $Password;

        return $this;
    }

    public function getIdCompany(): ?Companies
    {
        return $this->Id_company;
    }

    public function setIdCompany(?Companies $Id_company): static
    {
        $this->Id_company = $Id_company;

        return $this;
    }
}
