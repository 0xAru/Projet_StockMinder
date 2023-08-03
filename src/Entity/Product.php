<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Controller\ProductController;
use App\Repository\ProductRepository;
use App\Entity\Trait\SlugTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource(

    operations: [

    new Get(
        uriTemplate: '/{id}/products',
        controller: ProductController::class,
        name: 'app_product'
    ),

],
    normalizationContext: ['groups' => ['read:products']])]

class Product
{
    use SlugTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:products'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:products'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:products'])]
    private ?string $brand = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:products'])]
    private ?string $category = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:products'])]
    private ?string $style = null;

    #[ORM\Column(length: 500)]
    #[Groups(['read:products'])]
    private ?string $customer_description = null;

    #[ORM\Column(length: 600)]
    #[Groups(['read:products'])]
    private ?string $employee_description = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:products'])]
    private ?string $degree_of_alcohol = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:products'])]
    private ?string $origin = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:products'])]
    private ?string $capacity = null;

    #[ORM\Column]
    #[Groups(['read:products'])]
    private ?int $price = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:products'])]
    private ?int $promotion = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:products'])]
    private ?int $stock = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read:products'])]
    private ?int $threshold = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:products'])]
    private ?string $label = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getStyle(): ?string
    {
        return $this->style;
    }

    public function setStyle(string $style): static
    {
        $this->style = $style;

        return $this;
    }

    public function getCustomerDescription(): ?string
    {
        return $this->customer_description;
    }

    public function setCustomerDescription(string $customer_description): static
    {
        $this->customer_description = $customer_description;

        return $this;
    }

    public function getEmployeeDescription(): ?string
    {
        return $this->employee_description;
    }

    public function setEmployeeDescription(string $employee_description): static
    {
        $this->employee_description = $employee_description;

        return $this;
    }

    public function getDegreeOfAlcohol(): ?string
    {
        return $this->degree_of_alcohol;
    }

    public function setDegreeOfAlcohol(string $degree_of_alcohol): static
    {
        $this->degree_of_alcohol = $degree_of_alcohol;

        return $this;
    }

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function setOrigin(string $origin): static
    {
        $this->origin = $origin;

        return $this;
    }

    public function getCapacity(): ?string
    {
        return $this->capacity;
    }

    public function setCapacity(string $capacity): static
    {
        $this->capacity = $capacity;

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

    public function getPromotion(): ?int
    {
        return $this->promotion;
    }

    public function setPromotion(?int $promotion): static
    {
        $this->promotion = $promotion;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(?int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    public function getThreshold(): ?int
    {
        return $this->threshold;
    }

    public function setThreshold(?int $threshold): static
    {
        $this->threshold = $threshold;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): static
    {
        $this->label = $label;

        return $this;
    }
}
