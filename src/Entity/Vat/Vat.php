<?php

namespace App\Entity\Vat;

class Vat implements VatInterface
{
    /** @var float */
    protected $rate;

    /**
     * @param float $rate
     */
    public function __construct(float $rate)
    {
        $this->rate = $rate;
    }

    /**
     * @inheritDoc
     */
    public function getVatRate(): float
    {
        return $this->rate;
    }
}