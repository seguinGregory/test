<?php

namespace App\Entity\ShippingFee;

use App\Exception\NegativeValueException;

class PackagedShippingFee extends ShippingFee implements ShippingFeeInterface
{
    /** @var int */
    protected $packagedItemsQuantity;

    /**
     * @param float $basePrice
     * @param int $packagedItemsQuantity
     * @throws NegativeValueException
     */
    public function __construct(float $basePrice, int $packagedItemsQuantity)
    {
        if($packagedItemsQuantity < 0) {
            throw new NegativeValueException('La quantité du package ne peut être négative');
        }

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