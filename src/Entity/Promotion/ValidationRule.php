<?php

namespace App\Entity\Promotion;

use App\Entity\Order;

class ValidationRule implements ValidationRuleInterface
{
    /** @var string */
    protected $errorCode;

    /** @var string */
    protected $errorMessage;

    /**
     * @param string $errorCode
     * @param string $errorMessage
     */
    public function __construct(string $errorCode, string $errorMessage)
    {
        $this->errorCode = $errorCode;
        $this->errorMessage = $errorMessage;
    }

    public function isValid(Order $order)
    {
        return true;
    }
}