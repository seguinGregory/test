<?php

namespace App\Service\ShippingFee;

use App\Entity\Order;
use App\Exception\PromotionValidationRuleException;
use App\Service\ShippingFee\Payload\ShippingFeeInfo;
use App\Validator\PromotionRulesValidator;

/**
 * Service en charge des calculs des frais de ports
 */
class Calculator
{
    /** @var PromotionRulesValidator */
    protected $promotionRulesValidator;

    /**
     * @param PromotionRulesValidator $promotionRulesValidator
     */
    public function __construct(PromotionRulesValidator $promotionRulesValidator)
    {
        $this->promotionRulesValidator = $promotionRulesValidator;
    }

    /**
     * Récupération du prix des frais de port pour une commande. Cette fonction prend en compte les frais de port offert si la promotion le permet
     * @param Order $order
     * @return float
     */
    public function getShippingFeeTotalPrice(Order $order): float
    {
        $shippingFeeTotalPrice = 0.0;

        if(!$this->hasFreeShippingFee($order)) {
            foreach($this->getShippingFeeInfos($order) as $brandProductsQuantity) {
                $shippingFeeTotalPrice += $brandProductsQuantity->getBrand()->getShippingFee()->getShippingFeePrice($brandProductsQuantity->getQuantity());
            }
        }

        return $shippingFeeTotalPrice;
    }

    /**
     * Vérification des frais de port offer via Promotion
     * @param Order $order
     * @return bool
     */
    private function hasFreeShippingFee(Order $order)
    {
        if(!is_null($order->getPromotion()) && $order->getPromotion()->isFreeDelivery()) {
            try {
                $this->promotionRulesValidator->validatePromotion($order);
                return true;
            } catch(PromotionValidationRuleException $e) {
                return false;
            }
        }

        return false;
    }

    /**
     * Récupération des infos pour le calcul des frais de port
     * @param Order $order
     * @return ShippingFeeInfo[] Tableau représentant le nombre d'article par marque
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