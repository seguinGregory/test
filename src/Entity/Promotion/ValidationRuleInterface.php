<?php

namespace App\Entity\Promotion;

use App\Entity\Order;
use App\Exception\PromotionValidationRuleException;

interface ValidationRuleInterface
{
    /**
     * @param Order $order
     * @return void
     * @throws PromotionValidationRuleException
     */
    public function isValid(Order $order);
}