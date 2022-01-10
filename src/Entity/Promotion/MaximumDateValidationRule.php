<?php

namespace App\Entity\Promotion;

use App\Entity\Order;
use App\Exception\PromotionValidationRuleException;

class MaximumDateValidationRule extends ValidationRule implements ValidationRuleInterface
{
    /** @var \DateTime */
    protected $maximumDate;

    /**
     * @param string $errorCode
     * @param string $errorMessage
     * @param \DateTime $maximumDate
     */
    public function __construct(string $errorCode, string $errorMessage, \DateTime $maximumDate)
    {
        parent::__construct($errorCode, $errorMessage);
        $this->maximumDate = $maximumDate;
    }

    /**
     * @inheritDoc
     */
    public function isValid(Order $order)
    {
        if($order->getSubmissionDate()->getTimestamp() > $this->maximumDate->getTimestamp()) {
            throw new PromotionValidationRuleException($this->errorMessage);
        }
    }
}