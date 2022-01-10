<?php

namespace App\Entity\Promotion;

use App\Entity\Order;
use App\Exception\NegativeValueException;
use App\Exception\PromotionValidationRuleException;

class MinimumItemsQuantityValidationRule extends ValidationRule implements ValidationRuleInterface
{
    /** @var int */
    protected $minimumItemsQuantity;

    /**
     * @param string $errorCode
     * @param string $errorMessage
     * @param int $minimumItemsQuantity
     * @throws NegativeValueException
     */
    public function __construct(string $errorCode, string $errorMessage, int $minimumItemsQuantity)
    {
        if($minimumItemsQuantity < 0) {
            throw new NegativeValueException('La quantité minimum ne peut être négative');
        }

        parent::__construct($errorCode, $errorMessage);
        $this->minimumItemsQuantity = $minimumItemsQuantity;
    }

    /**
     * @inheritDoc
     */
    public function isValid(Order $order)
    {
        if($order->getProductQuantity() < $this->minimumItemsQuantity) {
            throw new PromotionValidationRuleException($this->errorMessage);
        }
    }
}