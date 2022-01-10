<?php

namespace App\Entity\Vat;

use App\Exception\InvalidRateException;

class CountryVatRate
{
    /** @var string */
    protected $country;

    /** @var float */
    protected $rate;

    /**
     * @param string $country
     * @param float $rate
     */
    public function __construct(string $country, float $rate)
    {
        if($rate < 0.0 || $rate > 100.0) {
            throw new InvalidRateException('Le taux doit être compris entre 0 et 100');
        }

        $this->country = $country;
        $this->rate = $rate;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return CountryVatRate
     */
    public function setCountry(string $country): CountryVatRate
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return float
     */
    public function getRate(): float
    {
        return $this->rate;
    }

    /**
     * @param float $rate
     * @return CountryVatRate
     */
    public function setRate(float $rate): CountryVatRate
    {
        $this->rate = $rate;
        return $this;
    }
}