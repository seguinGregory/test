<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Brand;
use App\Entity\Item;
use App\Entity\Order;
use App\Entity\Product;
use App\Service\Price\Calculator;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    /** @var Order */
    protected $sut;

    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->sut = new Order([
            new Item(new Product("test1", 10, $this->createMock(Brand::class)), 3),
            new Item(new Product("test2", 10, $this->createMock(Brand::class)), 1)
        ], new \DateTime());
    }

    public function testGetProductQuantity(): void
    {
        $this->assertEquals(4, $this->sut->getProductQuantity());
    }
}