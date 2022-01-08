<?php

namespace App\Entity\Promotion;

use App\Entity\Order;
use App\Exception\PromotionValidationRuleException;

class MinimumItemsQuantityValidationRule implements ValidationRuleInterface
{
    /** @var int */
    protected $minimumItemsQuantity;

    /**
     * @param int $minimumItemsQuantity
     */
    public function __construct(int $minimumItemsQuantity)
    {
        $this->minimumItemsQuantity = $minimumItemsQuantity;
    }

    /**
     * @inheritDoc
     */
    public function isValid(Order $order)
    {
        if(count($order->getItems()) < $this->minimumItemsQuantity) {
            throw new PromotionValidationRuleException('Cette promotion ne s\'applique pas sur ce nombre d\'articles (nombre minimum : ' . $this->minimumItemsQuantity . ')');
        }
    }
}