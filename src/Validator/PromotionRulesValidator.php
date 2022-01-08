<?php

namespace App\Validator;

use App\Entity\Order;
use App\Entity\Promotion;
use App\Exception\PromotionValidationRuleException;

class PromotionRulesValidator
{
    /**
     * @param Order $order
     * @return void
     * @throws PromotionValidationRuleException
     */
    public function validatePromotion(Order $order): void
    {
        if ($order->getPromotion()->getRemainingUses() <= 0) {
            throw new PromotionValidationRuleException('Cette promotion n\'est plus utilisable');
        }

        foreach ($order->getPromotion()->getValidationRules() as $validationRule) {
            $validationRule->isValid($order);
        }
    }
}