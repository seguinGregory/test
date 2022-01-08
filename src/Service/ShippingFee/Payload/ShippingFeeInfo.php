<?php

namespace App\Service\ShippingFee\Payload;

use App\Entity\Brand;

class ShippingFeeInfo
{
    /** @var Brand */
    protected $brand;

    /** @var int */
    protected $quantity;

    /**
     * @param Brand $brand
     * @param int $quantity
     */
    public function __construct(Brand $brand, int $quantity)
    {
        $this->brand = $brand;
        $this->quantity = $quantity;
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
     * @return ShippingFeeInfo
     */
    public function setBrand(Brand $brand): ShippingFeeInfo
    {
        $this->brand = $brand;
        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     * @return ShippingFeeInfo
     */
    public function setQuantity(int $quantity): ShippingFeeInfo
    {
        $this->quantity = $quantity;
        return $this;
    }
}