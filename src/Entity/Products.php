<?php

namespace App\Entity;

use App\Repository\ProductsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductsRepository::class)
 */
class Products
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $manage;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category_type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $product_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $company_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $color;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $power_consumption;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $material_type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $height;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $width;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $weight;

    /** 
     * @ORM\Column(type="string", columnDefinition="ENUM('AC', 'DC')") 
     */
    private $current_type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $warranty;

    /** 
     * @ORM\Column(type="string", columnDefinition="ENUM('1', '2', '3', '4', '5')") 
     */
    private $star_ratings;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $model_no;

    /** 
     * @ORM\Column(type="string", columnDefinition="ENUM('new', 'review', 'publish')") 
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_At;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_At;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getManage(): ?User
    {
        return $this->manage;
    }

    public function setManage(?User $manage): self
    {
        $this->manage = $manage;

        return $this;
    }

    public function getCategoryType(): ?Category
    {
        return $this->category_type;
    }

    public function setCategoryType(?Category $category_type): self
    {
        $this->category_type = $category_type;

        return $this;
    }

    public function getProductName(): ?string
    {
        return $this->product_name;
    }

    public function setProductName(string $product_name): self
    {
        $this->product_name = $product_name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->company_name;
    }

    public function setCompanyName(string $company_name): self
    {
        $this->company_name = $company_name;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getPowerConsumption(): ?string
    {
        return $this->power_consumption;
    }

    public function setPowerConsumption(string $power_consumption): self
    {
        $this->power_consumption = $power_consumption;

        return $this;
    }

    public function getMaterialType(): ?string
    {
        return $this->material_type;
    }

    public function setMaterialType(string $material_type): self
    {
        $this->material_type = $material_type;

        return $this;
    }

    public function getHeight(): ?string
    {
        return $this->height;
    }

    public function setHeight(string $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getWidth(): ?string
    {
        return $this->width;
    }

    public function setWidth(string $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getWeight(): ?string
    {
        return $this->weight;
    }

    public function setWeight(string $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getCurrentType(): ?string
    {
        return $this->current_type;
    }

    public function setCurrentType(string $current_type): self
    {
        $this->current_type = $current_type;

        return $this;
    }

    public function getWarranty(): ?string
    {
        return $this->warranty;
    }

    public function setWarranty(string $warranty): self
    {
        $this->warranty = $warranty;

        return $this;
    }

    public function getStarRatings(): ?string
    {
        return $this->star_ratings;
    }

    public function setStarRatings(string $star_ratings): self
    {
        $this->star_ratings = $star_ratings;

        return $this;
    }

    public function getModelNo(): ?string
    {
        return $this->model_no;
    }

    public function setModelNo(string $model_no): self
    {
        $this->model_no = $model_no;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_At;
    }

    public function setCreatedAt(\DateTimeInterface $created_At): self
    {
        $this->created_At = $created_At;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_At;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_At): self
    {
        $this->updated_At = $updated_At;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }
}
