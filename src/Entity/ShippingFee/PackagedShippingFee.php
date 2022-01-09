<?php

namespace App\Entity\ShippingFee;

class PackagedShippingFee extends ShippingFee implements ShippingFeeInterface
{
    /** @var int */
    protected $packagedItemsQuantity;

    /**
     * @param float $basePrice
     * @param int $packagedItemsQuantity
     */
    public function __construct(float $basePrice, int $packagedItemsQuantity)
    {
        parent::__construct($basePrice);
        $this->packagedItemsQuantity = $packagedItemsQuantity;
    }

    /**
     * @inheritDoc
     */
    public function getShippingFeePrice(int $itemQuantity): float
    {
        $packageQuantity = ceil($itemQuantity / $this->packagedItemsQuantity);

        return $packageQuantity * $this->basePrice;
    }
}