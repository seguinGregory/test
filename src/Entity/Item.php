<?php


namespace App\Entity;

use App\Entity\Product;
use App\Exception\NegativeValueException;

class Item
{
    /** @var Product */
    protected $product;

    /** @var int */
    protected $quantity;

    /**
     * @param Product $product
     * @param int $quantity
     */
    public function __construct(Product $product, int $quantity)
    {
        if($quantity < 0.0) {
            throw new NegativeValueException('La quantité ne peut être négative');
        }

        $this->product = $product;
        $this->quantity = $quantity;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     * @return Item
     */
    public function setProduct(Product $product): Item
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     * @return Item
     */
    public function setQuantity(int $quantity): Item
    {
        $this->quantity = $quantity;
        return $this;
    }
}
