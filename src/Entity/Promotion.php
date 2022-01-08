<?php


namespace App\Entity;


use App\Entity\Promotion\ValidationRuleInterface;
use App\Exception\PromotionValidationRuleException;

class Promotion
{
    /** @var string */
    protected $name;

    /** @var float */
    protected $reduction;

    /** @var bool */
    protected $freeDelivery;

    /** @var int */
    protected $remainingUses;

    /** @var ValidationRuleInterface[] */
    protected $validationRules;

    /**
     * @param string $name
     * @param float $reduction
     * @param bool $freeDelivery
     * @param int $remainingUses
     * @param ValidationRuleInterface[] $validationRules
     */
    public function __construct(string $name, float $reduction, bool $freeDelivery, int $remainingUses, array $validationRules)
    {
        $this->name = $name;
        $this->reduction = $reduction;
        $this->freeDelivery = $freeDelivery;
        $this->remainingUses = $remainingUses;
        $this->validationRules = $validationRules;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Promotion
     */
    public function setName(string $name): Promotion
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return float
     */
    public function getReduction(): float
    {
        return $this->reduction;
    }

    /**
     * @param float $reduction
     * @return Promotion
     */
    public function setReduction(float $reduction): Promotion
    {
        $this->reduction = $reduction;
        return $this;
    }

    /**
     * @return bool
     */
    public function isFreeDelivery(): bool
    {
        return $this->freeDelivery;
    }

    /**
     * @param bool $freeDelivery
     * @return Promotion
     */
    public function setFreeDelivery(bool $freeDelivery): Promotion
    {
        $this->freeDelivery = $freeDelivery;
        return $this;
    }

    /**
     * @return int
     */
    public function getRemainingUses(): int
    {
        return $this->remainingUses;
    }

    /**
     * @param int $remainingUses
     * @return Promotion
     */
    public function setRemainingUses(int $remainingUses): Promotion
    {
        $this->remainingUses = $remainingUses;
        return $this;
    }

    /**
     * @return ValidationRuleInterface[]
     */
    public function getValidationRules(): array
    {
        return $this->validationRules;
    }

    /**
     * @param ValidationRuleInterface[] $validationRules
     * @return Promotion
     */
    public function setValidationRules(array $validationRules): Promotion
    {
        $this->validationRules = $validationRules;
        return $this;
    }

    /**
     * @param ValidationRuleInterface $validationRule
     * @return Promotion
     */
    public function addValidationRules(ValidationRuleInterface $validationRule): Promotion {
        $this->validationRules[] = $validationRule;
        return $this;
    }

    /**
     * @param ValidationRuleInterface $validationRule
     * @return Promotion
     */
    public function removeValidationRules(ValidationRuleInterface $validationRule): Promotion {
        if($index = array_search($validationRule, $this->validationRules) !== false) {
            array_splice($this->validationRules, $index, 1);
        }
        return $this;
    }
}
