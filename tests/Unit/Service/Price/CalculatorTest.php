<?php

namespace App\Tests\Unit\Service\Price;

use App\Entity\Brand;
use App\Entity\Item;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Promotion;
use App\Entity\ShippingFee\ShippingFee;
use App\Entity\Vat\Vat;
use App\Service\Price\Calculator;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    /** @var Calculator */
    protected $sut;

    /** @var \App\Service\ShippingFee\Calculator */
    protected $shippingFeeCalculator;

    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->shippingFeeCalculator = $this->getMockBuilder(\App\Service\ShippingFee\Calculator::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'getShippingFeeTotalPrice'
            ])
            ->getMock();

        $this->sut = new Calculator($this->shippingFeeCalculator);
    }

    /**
     * @dataProvider dpForTestGetItemVatFreeTotalPrice
     */
    public function testGetItemVatFreeTotalPrice(Item $item, float $expectedPrice): void
    {
        $this->assertEquals($expectedPrice, $this->sut->getItemVatFreeTotalPrice($item));
    }

    /**
     * @return array[]
     */
    public function dpForTestGetItemVatFreeTotalPrice(): array
    {
        return [
            'OK' => [
                "item" => new Item(new Product("test1", 10.2, $this->createMock(Brand::class)), 3),
                "expectedPrice" => 30.6
            ]
        ];
    }

    /**
     * @dataProvider dpForTestGetItemVatFreeTotalPrice
     */
    public function testGetItemTotalPrice(Item $item, float $expectedPrice): void
    {
        $this->assertEquals($expectedPrice, $this->sut->getItemTotalPrice($item, 'FRA'));
    }

    /**
     * @return array[]
     */
    public function dpForTestGetItemTotalPrice(): array
    {
        return [
            'OK' => [
                "item" => new Item(new Product("test1", 10, new Brand('test1', $this->createMock(ShippingFee::class), new Vat(10))), 3),
                "expectedPrice" => 33
            ]
        ];
    }

    /**
     * @dataProvider dpForTestGetTotalPrice
     */
    public function testGetTotalPrice(Order $order, float $expectedPrice): void
    {
        $this->assertEquals($expectedPrice, $this->sut->getTotalPrice($order));
    }

    /**
     * @return array[]
     */
    public function dpForTestGetTotalPrice(): array
    {
        return [
            'OK' => [
                "order" => new Order([
                    new Item(new Product("test1", 10, new Brand('test1', $this->createMock(ShippingFee::class), new Vat(10))), 3),
                    new Item(new Product("test2", 10, new Brand('test1', $this->createMock(ShippingFee::class), new Vat(20))), 1)
                ], new \DateTime(), 'FRA'),
                "expectedPrice" => 45
            ]
        ];
    }

    /**
     * @dataProvider dpForTestGetVatFreeSubtotalPrice
     */
    public function testGetVatFreeSubtotalPrice(Order $order, float $expectedPrice): void
    {
        $this->assertEquals($expectedPrice, $this->sut->getVatFreeSubtotalPrice($order));
    }

    /**
     * @return array[]
     */
    public function dpForTestGetVatFreeSubtotalPrice(): array
    {
        return [
            'OK' => [
                "order" => new Order([
                    new Item(new Product("test1", 10, $this->createMock(Brand::class)), 3),
                    new Item(new Product("test2", 10, $this->createMock(Brand::class)), 1)
                ], new \DateTime(), 'FRA'),
                "expectedPrice" => 40
            ]
        ];
    }

    /**
     * @dataProvider dpForTestGetVatFreeTotalPrice
     */
    public function testGetVatFreeTotalPrice(Order $order, float $shippingFeePrice, float $expectedPrice): void
    {
        $this->shippingFeeCalculator->method('getShippingFeeTotalPrice')->willReturn($shippingFeePrice);

        $this->assertEquals($expectedPrice, $this->sut->getVatFreeTotalPrice($order));
    }

    /**
     * @return array[]
     */
    public function dpForTestGetVatFreeTotalPrice(): array
    {
        return [
            'OK sans promo' => [
                "order" => new Order([
                    new Item(new Product("test1", 10, $this->createMock(Brand::class)), 3),
                    new Item(new Product("test2", 10, $this->createMock(Brand::class)), 1)
                ], new \DateTime(), 'FRA'),
                "shippingFeePrice" => 8,
                "expectedPrice" => 48
            ],
            'OK avec promo (frais de port non offert)' => [
                "order" => (new Order([
                    new Item(new Product("test1", 10, $this->createMock(Brand::class)), 3),
                    new Item(new Product("test2", 10, $this->createMock(Brand::class)), 1)
                ], new \DateTime(), 'FRA'))->setPromotion(new Promotion('test1', 10, false, 1, [])),
                "shippingFeePrice" => 8,
                "expectedPrice" => 43.2
            ],
            'OK avec promo (frais de port offert)' => [
                "order" => (new Order([
                    new Item(new Product("test1", 10, $this->createMock(Brand::class)), 3),
                    new Item(new Product("test2", 10, $this->createMock(Brand::class)), 1)
                ], new \DateTime(), 'FRA'))->setPromotion(new Promotion('test1', 10, true, 1, [])),
                "shippingFeePrice" => 0,
                "expectedPrice" => 36
            ],
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

    public function testApplyVat(): void
    {
        $this->assertEquals(12, $this->invokeMethod($this->sut, 'applyVat', [10, 20]));
    }

    public function testApplyReduction(): void
    {
        $this->assertEquals(8, $this->invokeMethod($this->sut, 'applyReduction', [10, 20]));
    }
}