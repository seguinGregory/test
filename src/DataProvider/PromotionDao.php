<?php

namespace App\DataProvider;

use App\Entity\Promotion;

class PromotionDao
{
    public function getPromotionByName(): Promotion
    {
        return new Promotion('Promo', 20, false, 1, []);
    }
}