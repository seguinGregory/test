<?php

namespace App\Entity\Promotion;

use App\Entity\Order;
use App\Exception\PromotionValidationRuleException;

class MinimumDateValidationRule extends ValidationRule implements ValidationRuleInterface
{
    /** @var \DateTime */
    protected $minimumDate;

    /**
     * @param string $errorCode
     * @param string $errorMessage
     * @param \DateTime $minimumDate
     */
    public function __construct(string $errorCode, string $errorMessage, \DateTime $minimumDate)
    {
        parent::__construct($errorCode, $errorMessage);
        $this->minimumDate = $minimumDate;
    }

    /**
     * @inheritDoc
     */
    public function isValid(Order $order)
    {
        if($order->getSubmissionDate()->getTimestamp() < $this->minimumDate->getTimestamp()) {
            throw new PromotionValidationRuleException($this->errorMessage);
        }
    }
}