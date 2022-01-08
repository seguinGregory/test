<?php

namespace App\Entity\Vat;

class FixedVat implements VatInterface
{
    /** @var float */
    protected $rate;

    /**
     * @param float $price
     */
    public function __construct(float $price)
    {
        $this->rate = $price;
    }

    public function getVatRate(): float
    {
        return $this->rate;
    }
}