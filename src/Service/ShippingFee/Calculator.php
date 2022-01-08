<?php

namespace App\Service\ShippingFee;

use App\Entity\Order;
use App\Service\ShippingFee\Payload\ShippingFeeInfo;

class Calculator
{
    /**
     * @param Order $order
     * @return float
     */
    public function getShippingFeeTotalPrice(Order $order): float
    {
        $shippingFeeTotalPrice = 0.0;

        if(!is_null($order->getPromotion()) && !$order->getPromotion()->isFreeDelivery()) {
            foreach($this->getShippingFeeInfos($order) as $brandProductsQuantity) {
                $shippingFeeTotalPrice += $brandProductsQuantity->getBrand()->getShippingFee()->getShippingFeePrice($brandProductsQuantity->getQuantity());
            }
        }

        return $shippingFeeTotalPrice;
    }

    /**
     * @param Order $order
     * @return array
     */
    private function getShippingFeeInfos(Order $order): array
    {
        /** @var ShippingFeeInfo[] $shippingFeeInfos */
        $shippingFeeInfos = [];
        foreach($order->getItems() as $item) {
            $quantity = $item->getQuantity();
            if(isset($shippingFeeInfos[$item->getProduct()->getBrand()->getName()])) {
                $quantity = $shippingFeeInfos[$item->getProduct()->getBrand()->getName()]->getQuantity() + $item->getQuantity();
            }
            $shippingFeeInfos[$item->getProduct()->getBrand()->getName()] = new ShippingFeeInfo($item->getProduct()->getBrand(), $quantity);
        }

        return $shippingFeeInfos;
    }
}