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
     * @return Promotion
     */
    public function getPromotionByName(): Promotion
    {
        return new Promotion('Promo', 20, false, 1, [new Promotion\MinimumItemsQuantityValidationRule('ERR01', 'La quantité d\'articles dans le panier n\'est pas suffisante', 4)]);
    }
}