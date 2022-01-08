<?php

namespace App\Entity\ShippingFee;

interface ShippingFeeInterface
{
    /**
     * @param int $itemQuantity
     * @return float
     */
    public function getShippingFeePrice(int $itemQuantity): float;
}