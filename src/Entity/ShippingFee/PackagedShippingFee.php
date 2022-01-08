<?php

namespace App\Entity\ShippingFee;

class PackagedShippingFee implements ShippingFeeInterface
{
    /** @var int */
    protected $packagedItemsQuantity;

    /** @var float */
    protected $packagedPrice;

    /**
     * @param int $packagedItemsQuantity
     * @param float $packagedPrice
     */
    public function __construct(int $packagedItemsQuantity, float $packagedPrice)
    {
        $this->packagedItemsQuantity = $packagedItemsQuantity;
        $this->packagedPrice = $packagedPrice;
    }

    /**
     * @param int $itemQuantity
     * @return float
     */
    public function getShippingFeePrice(int $itemQuantity): float
    {
        $packageQuantity = ceil($itemQuantity / $this->packagedItemsQuantity);

        return $packageQuantity * $this->packagedPrice;
    }
}