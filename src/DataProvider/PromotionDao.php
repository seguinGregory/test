<?php

namespace App\DataProvider;

use App\Entity\Promotion;

/**
 * Récupération des données (en dur ici mais possiblement depuis API ou BDD)
 */
class PromotionDao
{
    /**
     * Simulation d'une recupération par code promo
     *
     * L'utilisation de key Symfony Translation serait mieux pour les messages d'erreur
     * @return Promotion
     * @throws \App\Exception\InvalidRateException
     * @throws \App\Exception\NegativeValueException
     */
    public function getPromotionByName(): Promotion
    {
        return new Promotion('Promo', 20, false, 1, [new Promotion\MinimumItemsQuantityValidationRule('ERR01', 'La quantité d\'articles dans le panier n\'est pas suffisante', 4)]);
    }
}