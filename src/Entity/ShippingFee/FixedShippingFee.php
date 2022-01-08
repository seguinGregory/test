<?php

namespace App\Entity\ShippingFee;

class FixedShippingFee implements ShippingFeeInterface
{
    /** @var float */
    protected $price;

    /**
     * @param float $price
     */
    public function __construct(float $price)
    {
        $this->price = $price;
    }

    /**
     * @param int $itemQuantity
     * @return float
     */
    public function getShippingFeePrice(int $itemQuantity): float
    {
        return $this->price;
    }
}