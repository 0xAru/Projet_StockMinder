<?php

namespace App\Entity;

use App\Repository\CompaniesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompaniesRepository::class)]
class Companies
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(length: 255)]
    private ?string $Director_lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $Director_firstname = null;

    #[ORM\Column]
    private ?int $Siret = null;

    #[ORM\Column]
    private ?int $User_position = null;

    #[ORM\Column(length: 255)]
    private ?string $Adress = null;

    #[ORM\Column]
    private ?int $Postal_code = null;

    #[ORM\Column(length: 255)]
    private ?string $City = null;

    #[ORM\Column(length: 255)]
    private ?string $Email = null;

    #[ORM\Column(length: 255)]
    private ?string $Password = null;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Users::class, orphanRemoval: true)]
    private Collection $Users;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Events::class, orphanRemoval: true)]
    private Collection $Events;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Products::class, orphanRemoval: true)]
    private Collection $Products;

    public function __construct()
    {
        $this->Users = new ArrayCollection();
        $this->Events = new ArrayCollection();
        $this->Products = new ArrayCollection();
    }

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

    public function getDirectorLastname(): ?string
    {
        return $this->Director_lastname;
    }

    public function setDirectorLastname(string $Director_lastname): static
    {
        $this->Director_lastname = $Director_lastname;

        return $this;
    }

    public function getDirectorFirstname(): ?string
    {
        return $this->Director_firstname;
    }

    public function setDirectorFirstname(string $Director_firstname): static
    {
        $this->Director_firstname = $Director_firstname;

        return $this;
    }

    public function getSiret(): ?int
    {
        return $this->Siret;
    }

    public function setSiret(int $Siret): static
    {
        $this->Siret = $Siret;

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

    public function getAdress(): ?string
    {
        return $this->Adress;
    }

    public function setAdress(string $Adress): static
    {
        $this->Adress = $Adress;

        return $this;
    }

    public function getPostalCode(): ?int
    {
        return $this->Postal_code;
    }

    public function setPostalCode(int $Postal_code): static
    {
        $this->Postal_code = $Postal_code;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->City;
    }

    public function setCity(string $City): static
    {
        $this->City = $City;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): static
    {
        $this->Email = $Email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->Password;
    }

    public function setPassword(string $Password): static
    {
        $this->Password = $Password;

        return $this;
    }

    /**
     * @return Collection<int, Users>
     */
    public function getIdUser(): Collection
    {
        return $this->Users;
    }

    public function addIdUser(Users $idUser): static
    {
        if (!$this->Users->contains($idUser)) {
            $this->Users->add($idUser);
            $idUser->setIdCompany($this);
        }

        return $this;
    }

    public function removeIdUser(Users $idUser): static
    {
        if ($this->Users->removeElement($idUser)) {
            // set the owning side to null (unless already changed)
            if ($idUser->getIdCompany() === $this) {
                $idUser->setIdCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Events>
     */
    public function getEvents(): Collection
    {
        return $this->Events;
    }

    public function addEvent(Events $Event): static
    {
        if (!$this->Events->contains($Event)) {
            $this->Events->add($Event);
            $Event->setIdCompany($this);
        }

        return $this;
    }

    public function removeEvent(Events $Event): static
    {
        if ($this->Events->removeElement($Event)) {
            // set the owning side to null (unless already changed)
            if ($Event->getIdCompany() === $this) {
                $Event->setIdCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Products>
     */
    public function getProducts(): Collection
    {
        return $this->Products;
    }

    public function addProduct(Products $product): static
    {
        if (!$this->Products->contains($product)) {
            $this->Products->add($product);
            $product->setCompanyId($this);
        }

        return $this;
    }

    public function removeProduct(Products $product): static
    {
        if ($this->Products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getCompanyId() === $this) {
                $product->setCompanyId(null);
            }
        }

        return $this;
    }
}
