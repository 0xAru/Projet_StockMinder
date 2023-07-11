<?php

namespace App\Entity;

use App\Repository\ProductsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductsRepository::class)]
class Products
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(length: 255)]
    private ?string $Brand = null;

    #[ORM\Column(length: 255)]
    private ?string $Category = null;

    #[ORM\Column(length: 255)]
    private ?string $Style = null;

    #[ORM\Column(length: 550)]
    private ?string $Customer_description = null;

    #[ORM\Column(length: 550)]
    private ?string $Employee_description = null;

    #[ORM\Column]
    private ?int $Degre_of_alcool = null;

    #[ORM\Column(length: 255)]
    private ?string $Origin = null;

    #[ORM\Column(length: 255)]
    private ?string $Capacity = null;

    #[ORM\Column]
    private ?float $Price = null;

    #[ORM\Column(nullable: true)]
    private ?int $Promotion = null;

    #[ORM\Column(nullable: true)]
    private ?int $Stock = null;

    #[ORM\Column]
    private ?int $Threshold = null;

    #[ORM\ManyToOne(inversedBy: 'Products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Companies $Company_id = null;

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

    public function getBrand(): ?string
    {
        return $this->Brand;
    }

    public function setBrand(string $Brand): static
    {
        $this->Brand = $Brand;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->Category;
    }

    public function setCategory(string $Category): static
    {
        $this->Category = $Category;

        return $this;
    }

    public function getStyle(): ?string
    {
        return $this->Style;
    }

    public function setStyle(string $Style): static
    {
        $this->Style = $Style;

        return $this;
    }

    public function getCustomerDescription(): ?string
    {
        return $this->Customer_description;
    }

    public function setCustomerDescription(string $Customer_description): static
    {
        $this->Customer_description = $Customer_description;

        return $this;
    }

    public function getEmployeeDescription(): ?string
    {
        return $this->Employee_description;
    }

    public function setEmployeeDescription(string $Employee_description): static
    {
        $this->Employee_description = $Employee_description;

        return $this;
    }

    public function getDegreOfAlcool(): ?int
    {
        return $this->Degre_of_alcool;
    }

    public function setDegreOfAlcool(int $Degre_of_alcool): static
    {
        $this->Degre_of_alcool = $Degre_of_alcool;

        return $this;
    }

    public function getOrigin(): ?string
    {
        return $this->Origin;
    }

    public function setOrigin(string $Origin): static
    {
        $this->Origin = $Origin;

        return $this;
    }

    public function getCapacity(): ?string
    {
        return $this->Capacity;
    }

    public function setCapacity(string $Capacity): static
    {
        $this->Capacity = $Capacity;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->Price;
    }

    public function setPrice(float $Price): static
    {
        $this->Price = $Price;

        return $this;
    }

    public function getPromotion(): ?int
    {
        return $this->Promotion;
    }

    public function setPromotion(?int $Promotion): static
    {
        $this->Promotion = $Promotion;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->Stock;
    }

    public function setStock(?int $Stock): static
    {
        $this->Stock = $Stock;

        return $this;
    }

    public function getThreshold(): ?int
    {
        return $this->Threshold;
    }

    public function setThreshold(int $Threshold): static
    {
        $this->Threshold = $Threshold;

        return $this;
    }

    public function getCompanyId(): ?Companies
    {
        return $this->Company_id;
    }

    public function setCompanyId(?Companies $Company_id): static
    {
        $this->Company_id = $Company_id;

        return $this;
    }
}
