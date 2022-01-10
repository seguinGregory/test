<?php

namespace App\Entity\ShippingFee;

use App\Exception\NegativeValueException;

class ShippingFee implements ShippingFeeInterface
{
    /** @var float */
    protected $basePrice;

    /**
     * @param float $price
     * @throws NegativeValueException
     */
    public function __construct(float $price)
    {
        if($price < 0.0) {
            throw new NegativeValueException('Le prix ne peut être négatif');
        }

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