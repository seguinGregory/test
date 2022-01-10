<?php

namespace App\Service\Price;

use App\Entity\Item;
use App\Entity\Order;

/**
 * Service en charge des calculs de prix
 */
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

    /**
     * Récupération du prix du sous-total HT pour une commande
     * @param Order $order
     * @return float
     */
    public function getVatFreeSubtotalPrice(Order $order): float
    {
        $vatFreeSubtotalPrice = 0.0;

        foreach($order->getItems() AS $item) {
            $vatFreeSubtotalPrice += $this->getItemVatFreeTotalPrice($item);
        }

        return $vatFreeSubtotalPrice;
    }

    /**
     * Récupération du prix du total HT pour une commande. Ce prix correspond au sous-total HT + frais de port HT - réduction de la promotion si existante
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
     * Récupération du prix du total TTC pour une commande
     * @param Order $order
     * @return float
     */
    public function getTotalPrice(Order $order): float
    {
        $totalPrice = 0.0;

        foreach($order->getItems() as $item) {
            $totalPrice += $this->getItemTotalPrice($item, $order->getBillingCountry());
        }

        return $totalPrice;
    }

    /**
     * Récupération du prix du total HT pour un item. Il correspond au prix unitaire * quantité
     * @param Item $item
     * @return float
     */
    public function getItemVatFreeTotalPrice(Item $item): float
    {
        return $item->getProduct()->getPrice() * $item->getQuantity();
    }

    /**
     * Récupération du prix du total TTC pour un item. Il correspond au total HT + application de la TVA
     * @param Item $item
     * @return float
     */
    public function getItemTotalPrice(Item $item, string $billingCountry): float
    {
        return $this->applyVat($this->getItemVatFreeTotalPrice($item), $item->getProduct()->getBrand()->getVat()->getVatRate($billingCountry));
    }

    /**
     * Application d'un taux de TVA sur un prix HT
     * @param float $price Prix HT
     * @param float $vatRate Taux de la TVA (en %)
     * @return float
     */
    private function applyVat(float $price, float $vatRate): float
    {
        return $price + ($price *  $vatRate / 100);
    }

    /**
     * Application d'une réduction sur un prix
     * @param float $price Prix
     * @param float $reduction Taux de la réduction (en %)
     * @return float
     */
    private function applyReduction(float $price, float $reduction): float
    {
        return $price - ($price *  $reduction / 100);
    }
}