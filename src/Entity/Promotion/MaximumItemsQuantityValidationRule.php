<?php

namespace App\Entity\Promotion;

use App\Entity\Order;
use App\Exception\NegativeValueException;
use App\Exception\PromotionValidationRuleException;

class MaximumItemsQuantityValidationRule extends ValidationRule implements ValidationRuleInterface
{
    /** @var int */
    protected $maximumItemsQuantity;

    /**
     * @param string $errorCode
     * @param string $errorMessage
     * @param int $maximumItemsQuantity
     * @throws NegativeValueException
     */
    public function __construct(string $errorCode, string $errorMessage, int $maximumItemsQuantity)
    {
        if($maximumItemsQuantity < 0) {
            throw new NegativeValueException('La quantité maximum ne peut être négative');
        }

        parent::__construct($errorCode, $errorMessage);
        $this->maximumItemsQuantity = $maximumItemsQuantity;
    }

    /**
     * @inheritDoc
     */
    public function isValid(Order $order)
    {
        if($order->getProductQuantity() > $this->maximumItemsQuantity) {
            throw new PromotionValidationRuleException($this->errorMessage);
        }
    }
}