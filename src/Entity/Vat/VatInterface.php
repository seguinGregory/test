<?php

namespace App\Entity\Vat;

interface VatInterface
{
    /**
     * @return float
     */
    public function getVatRate(): float;
}