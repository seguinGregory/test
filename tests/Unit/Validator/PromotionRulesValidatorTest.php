<?php

namespace App\Tests\Unit\Validator;

use App\Entity\Order;
use App\Entity\Promotion;
use App\Exception\PromotionValidationRuleException;
use App\Service\ShippingFee\Calculator;
use App\Validator\PromotionRulesValidator;
use PHPUnit\Framework\TestCase;

class PromotionRulesValidatorTest extends TestCase
{
    /** @var Calculator */
    protected $sut;

    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->sut = new PromotionRulesValidator();
    }

    /**
     * @dataProvider dpForTestValidatePromotion
     */
    public function testValidatePromotion(Order $order, $expectedException, $expectedExceptionMessage): void
    {
        if(!is_null($expectedException)) {
            $this->expectException($expectedException);
            $this->expectException($expectedException);
        }

        $this->sut->validatePromotion($order);
    }

    /**
     * @return array[]
     */
    public function dpForTestValidatePromotion(): array
    {
        return [
            'OK utilisable' => [
                'order' => (new Order([], new \DateTime(), 'FRA'))->setPromotion(new Promotion('test1', 10, true, 1, [])),
                'expectedException' => null,
                'expectedExceptionMessage' => null
            ],
            'KO plus d\'utilisation' => [
                'order' => (new Order([], new \DateTime(), 'FRA'))->setPromotion(new Promotion('test1', 10, true, 0, [])),
                'expectedException' => PromotionValidationRuleException::class,
                'expectedExceptionMessage' => 'Cette promotion n\'est plus utilisable'
            ],
            'OK nombre d\'article minimal' => [
                'order' => (new Order([], new \DateTime(), 'FRA'))->setPromotion(new Promotion('test1', 10, true, 1, [new Promotion\MinimumItemsQuantityValidationRule('ERR01', 'test', 0)])),
                'expectedException' => null,
                'expectedExceptionMessage' => null
            ],
            'KO nombre d\'article minimal' => [
                'order' => (new Order([], new \DateTime(), 'FRA'))->setPromotion(new Promotion('test1', 10, true, 1, [new Promotion\MinimumItemsQuantityValidationRule('ERR01', 'test', 1)])),
                'expectedException' => PromotionValidationRuleException::class,
                'expectedExceptionMessage' => 'test'
            ]
        ];
    }
}