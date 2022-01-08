<?php

namespace App\Entity\Promotion;

use App\Entity\Order;
use App\Exception\PromotionValidationRuleException;

class MaximumItemsQuantityValidationRule implements ValidationRuleInterface
{
    /** @var int */
    protected $maximumItemsQuantity;

    /**
     * @param int $maximumItemsQuantity
     */
    public function __construct(int $maximumItemsQuantity)
    {
        $this->maximumItemsQuantity = $maximumItemsQuantity;
    }

    /**
     * @inheritDoc
     */
    public function isValid(Order $order)
    {
        if(count($order->getItems()) > $this->maximumItemsQuantity) {
            throw new PromotionValidationRuleException('Cette promotion ne s\'applique pas sur ce nombre d\'articles (nombre maximum : ' . $this->maximumItemsQuantity . ')');
        }
    }
}