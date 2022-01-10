<?php

namespace App\Entity;

use App\Entity\Brand;
use App\Exception\NegativeValueException;

class Product
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var float
     */
    protected $price;

    /**
     * @var Brand
     */
    protected $brand;

    /**
     * @param string $title
     * @param float $price
     * @param \App\Entity\Brand $brand
     * @throws NegativeValueException
     */
    public function __construct(string $title, float $price, Brand $brand)
    {
        if($price < 0.0) {
            throw new NegativeValueException('Le prix ne peut être négative');
        }

        $this->title = $title;
        $this->price = $price;
        $this->brand = $brand;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Product
     */
    public function setTitle(string $title): Product
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return Product
     */
    public function setPrice(float $price): Product
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return Brand
     */
    public function getBrand(): Brand
    {
        return $this->brand;
    }

    /**
     * @param Brand $brand
     * @return Product
     */
    public function setBrand(Brand $brand): Product
    {
        $this->brand = $brand;
        return $this;
    }
}
