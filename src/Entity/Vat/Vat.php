<?php

namespace App\Entity\Vat;

use App\Exception\InvalidRateException;

class Vat implements VatInterface
{
    /** @var float En % (float entre 0 et 1) */
    protected $rate;

    /**
     * @param float $rate
     * @throws InvalidRateException
     */
    public function __construct(float $rate)
    {
        if($rate < 0.0 || $rate > 100.0) {
            throw new InvalidRateException('Le taux doit être compris entre 0 et 100');
        }

        $this->rate = $rate;
    }

    /**
     * @inheritDoc
     */
    public function getVatRate(string $country = null): float
    {
        return $this->rate;
    }
}