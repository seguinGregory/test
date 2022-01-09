<?php

namespace App\Tests\Unit\Service\ShippingFee;

use App\Entity\Brand;
use App\Entity\Item;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Promotion;
use App\Entity\ShippingFee\PackagedShippingFee;
use App\Entity\ShippingFee\ShippingFee;
use App\Entity\Vat\Vat;
use App\Service\ShippingFee\Calculator;
use App\Service\ShippingFee\Payload\ShippingFeeInfo;
use App\Validator\PromotionRulesValidator;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    /** @var Calculator */
    protected $sut;

    /** @var PromotionRulesValidator */
    protected $promotionRulesValidator;

    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->promotionRulesValidator = $this->getMockBuilder(PromotionRulesValidator::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'validatePromotion'
            ])
            ->getMock();

        $this->sut = new Calculator($this->promotionRulesValidator);
    }

    /**
     * @dataProvider dpForTestGetShippingFeeTotalPrice
     */
    public function testGetShippingFeeTotalPrice(Order $order, float $expectedPrice): void
    {
        $this->assertEquals($expectedPrice, $this->sut->getShippingFeeTotalPrice($order));
    }

    /**
     * @return array[]
     */
    public function dpForTestGetShippingFeeTotalPrice(): array
    {
        return [
            'OK frais de port fixe et non offert' => [
                'order' => (new Order([
                    new Item(new Product("test1", 10, new Brand('test1', new ShippingFee(10), $this->createMock(Vat::class))), 3),
                    new Item(new Product("test2", 10, new Brand('test2', new ShippingFee(10), $this->createMock(Vat::class))), 1)
                ], new \DateTime()))->setPromotion(new Promotion('test1', 10, false, 1, [])),
                'expectedPrice' => 20
            ],
            'OK frais de port fixe et offert' => [
                'order' => (new Order([
                    new Item(new Product("test1", 10, new Brand('test1', new ShippingFee(10), $this->createMock(Vat::class))), 3),
                    new Item(new Product("test2", 10, new Brand('test2', new ShippingFee(10), $this->createMock(Vat::class))), 1)
                ], new \DateTime()))->setPromotion(new Promotion('test1', 10, true, 1, [])),
                'expectedPrice' => 0
            ],
            'OK frais de port fixe et packagé et non offert' => [
                'order' => (new Order([
                    new Item(new Product("test1", 10, new Brand('test1', new ShippingFee(10), $this->createMock(Vat::class))), 3),
                    new Item(new Product("test2", 10, new Brand('test2', new PackagedShippingFee(10, 3), $this->createMock(Vat::class))), 5)
                ], new \DateTime()))->setPromotion(new Promotion('test1', 10, false, 1, [])),
                'expectedPrice' => 30
            ],
            'OK frais de port fixe et packagé et offert' => [
                'order' => (new Order([
                    new Item(new Product("test1", 10, new Brand('test1', new ShippingFee(10), $this->createMock(Vat::class))), 3),
                    new Item(new Product("test2", 10, new Brand('test2', new PackagedShippingFee(10, 3), $this->createMock(Vat::class))), 5)
                ], new \DateTime()))->setPromotion(new Promotion('test1', 10, true, 1, [])),
                'expectedPrice' => 0
            ]
        ];
    }

    /**
     * Pour tester les functions privées
     * @param $object
     * @param $methodName
     * @param array $parameters
     * @return mixed
     * @throws \ReflectionException
     */
    private function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    public function testHasFreeShippingFee(): void
    {
        $this->assertTrue($this->invokeMethod($this->sut, 'hasFreeShippingFee', [(new Order([], new \DateTime()))->setPromotion(new Promotion('test1', 10, true, 1, []))]));

        $this->assertFalse($this->invokeMethod($this->sut, 'hasFreeShippingFee', [(new Order([], new \DateTime()))->setPromotion(new Promotion('test1', 10, false, 1, []))]));
    }

    public function testGetShippingFeeInfos(): void
    {
        $brand1 = new Brand('test1', new ShippingFee(10), $this->createMock(Vat::class));
        $brand2 = new Brand('test2', new PackagedShippingFee(10, 3), $this->createMock(Vat::class));

        $this->assertEquals([
            'test1' => new ShippingFeeInfo($brand1, 8),
            'test2' => new ShippingFeeInfo($brand2, 5)
        ],
            $this->invokeMethod($this->sut, 'getShippingFeeInfos', [(new Order([
                new Item(new Product("test1", 10, $brand1), 3),
                new Item(new Product("test2", 10, $brand1), 5),
                new Item(new Product("test2", 10, $brand2), 5)
            ], new \DateTime()))])
        );
    }
}