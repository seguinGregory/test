<?php


namespace App\Entity;


use App\Entity\Promotion\ValidationRule;
use App\Exception\InvalidRateException;
use App\Exception\NegativeValueException;

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

    /** @var ValidationRule[] */
    protected $validationRules;

    /**
     * @param string $name
     * @param float $reduction
     * @param bool $freeDelivery
     * @param int $remainingUses
     * @param array $validationRules
     * @throws InvalidRateException
     * @throws NegativeValueException
     */
    public function __construct(string $name, float $reduction, bool $freeDelivery, int $remainingUses, array $validationRules)
    {
        if($reduction < 0.0 || $reduction > 100.0) {
            throw new InvalidRateException('Le taux de réduction doit être compris entre 0 et 100');
        }

        if($remainingUses < 0.0) {
            throw new NegativeValueException('La quantité d\'utilisation restante ne peut être négative');
        }

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
     * @return ValidationRule[]
     */
    public function getValidationRules(): array
    {
        return $this->validationRules;
    }

    /**
     * @param ValidationRule[] $validationRules
     * @return Promotion
     */
    public function setValidationRules(array $validationRules): Promotion
    {
        $this->validationRules = $validationRules;
        return $this;
    }

    /**
     * @param ValidationRule $validationRule
     * @return Promotion
     */
    public function addValidationRule(ValidationRule $validationRule): Promotion {
        $this->validationRules[] = $validationRule;
        return $this;
    }

    /**
     * @param ValidationRule $validationRule
     * @return Promotion
     */
    public function removeValidationRule(ValidationRule $validationRule): Promotion {
        if($index = array_search($validationRule, $this->validationRules) !== false) {
            array_splice($this->validationRules, $index, 1);
        }
        return $this;
    }
}
