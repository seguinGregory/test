<?php

namespace App\Entity\Vat;

interface VatInterface
{
    /**
     * Récupération du taux de taxe (TVA)
     * @return float
     */
    public function getVatRate(string $country = null): float;
}