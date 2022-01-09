<?php

namespace App\Entity\ShippingFee;

class ShippingFee implements ShippingFeeInterface
{
    /** @var float */
    protected $basePrice;

    /**
     * @param float $price
     */
    public function __construct(float $price)
    {
        $this->basePrice = $price;
    }

    /**
     * @inheritDoc
     */
    public function getShippingFeePrice(int $itemQuantity): float
    {
        return $this->basePrice;
    }
}