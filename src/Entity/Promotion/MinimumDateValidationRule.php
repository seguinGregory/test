<?php

namespace App\Entity\Promotion;

use App\Entity\Order;
use App\Exception\PromotionValidationRuleException;

class MinimumDateValidationRule implements ValidationRuleInterface
{
    /** @var \DateTime */
    protected $minimumDate;

    /**
     * @param \DateTime $minimumDate
     */
    public function __construct(\DateTime $minimumDate)
    {
        $this->minimumDate = $minimumDate;
    }

    /**
     * @inheritDoc
     */
    public function isValid(Order $order)
    {
        if($order->getSubmissionDate()->getTimestamp() < $this->minimumDate->getTimestamp()) {
            throw new PromotionValidationRuleException('Cette promotion n\'est pas encore utilisable (utilisable à partir du ' . $this->minimumDate->format('dd/mm/YY') . ')');
        }
    }
}