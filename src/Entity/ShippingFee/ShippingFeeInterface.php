<?php

namespace App\Entity\ShippingFee;

interface ShippingFeeInterface
{
    /**
     * Récupération du prix des frais de port
     * @param int $itemQuantity
     * @return float
     */
    public function getShippingFeePrice(int $itemQuantity): float;
}