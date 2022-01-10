<?php

namespace App\Entity\Vat;

class CountriesVat extends Vat implements VatInterface
{
    /** @var CountryVatRate[] */
    protected $countriesRates;

    /**
     * @param float $defaultRate
     * @param array $countriesRates
     * @throws \App\Exception\InvalidRateException
     */
    public function __construct(float $defaultRate, array $countriesRates)
    {
        parent::__construct($defaultRate);
        $this->countriesRates = $countriesRates;
    }

    /**
     * @inheritDoc
     */
    public function getVatRate(string $country = null): float
    {
        $rate = parent::getVatRate();

        foreach($this->countriesRates AS $countryRate) {
            if($countryRate->getCountry() == $country) {
                $rate = $countryRate->getRate();
            }
        }

        return $rate;
    }
}