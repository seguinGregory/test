<?php

namespace App\Service\Price;

use App\Entity\Item;
use App\Entity\Order;

class Calculator
{
    /** @var \App\Service\ShippingFee\Calculator */
    protected $shippingFeeCalculator;

    /**
     * @param \App\Service\ShippingFee\Calculator $shippingFeeCalculator
     */
    public function __construct(\App\Service\ShippingFee\Calculator $shippingFeeCalculator)
    {
        $this->shippingFeeCalculator = $shippingFeeCalculator;
    }

    public function getVatFreeSubtotalPrice(Order $order): float
    {
        $vatFreeSubtotalPrice = 0.0;

        foreach($order->getItems() AS $item) {
            $vatFreeSubtotalPrice += $this->getItemTotalPrice($item);
        }

        return $vatFreeSubtotalPrice;
    }

    /**
     * @param Order $order
     * @return float
     */
    public function getVatFreeTotalPrice(Order $order): float
    {
        $vatFreeTotalPrice = $this->getVatFreeSubtotalPrice($order) + $this->shippingFeeCalculator->getShippingFeeTotalPrice($order);

        if(!is_null($order->getPromotion())) {
            $vatFreeTotalPrice = $this->applyReduction($vatFreeTotalPrice, $order->getPromotion()->getReduction());
        }

        return $vatFreeTotalPrice;
    }

    /**
     * @param Order $order
     * @return float
     */
    public function getTotalPrice(Order $order): float
    {
        $totalPrice = $this->getVatFreeTotalPrice($order);

        foreach($order->getItems() as $item) {
            $totalPrice += $this->applyVat($this->getItemTotalPrice($item), $item->getProduct()->getBrand()->getVat()->getVatRate());
        }

        return $totalPrice;
    }

    /**
     * @return float
     */
    private function getItemTotalPrice(Item $item): float
    {
        return $item->getProduct()->getPrice() * $item->getQuantity();
    }

    /**
     * @param float $price
     * @param float $vatRate
     * @return float
     */
    private function applyVat(float $price, float $vatRate): float
    {
        return $price + ($price *  $vatRate / 100);
    }

    /**
     * @param float $price
     * @param float $reduction
     * @return float
     */
    private function applyReduction(float $price, float $reduction): float
    {
        return $price - ($price *  $reduction / 100);
    }
}