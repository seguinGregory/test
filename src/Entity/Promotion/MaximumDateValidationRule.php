<?php

namespace App\Entity\Promotion;

use App\Entity\Order;
use App\Exception\PromotionValidationRuleException;
use Symfony\Component\Translation\TranslatableMessage;

class MaximumDateValidationRule implements ValidationRuleInterface
{
    /** @var \DateTime */
    protected $maximumDate;

    /**
     * @param \DateTime $maximumDate
     */
    public function __construct(\DateTime $maximumDate)
    {
        $this->maximumDate = $maximumDate;
    }

    /**
     * @inheritDoc
     */
    public function isValid(Order $order)
    {
        if($order->getSubmissionDate()->getTimestamp() > $this->maximumDate->getTimestamp()) {
            throw new PromotionValidationRuleException('Cette promotion n\'est plus utilisable (utilisable jusqu\'au ' . $this->maximumDate->format('dd/mm/YY') . ')');
        }
    }
}