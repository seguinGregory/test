<?php

namespace App\Controller;

use App\DataProvider\OrderDao;
use App\DataProvider\PromotionDao;
use App\Entity\Product;
use App\Entity\Promotion;
use App\Exception\PromotionValidationRuleException;
use App\Service\Price\Calculator;
use App\Validator\PromotionRulesValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class MainController extends AbstractController
{
    public function index(
        OrderDao $orderDao,
        PromotionDao $promotionDao,
        PromotionRulesValidator $promotionRulesValidator,
        Calculator $priceCalculator,
        \App\Service\ShippingFee\Calculator $shippingFeeCalculator
    ): Response
    {
        $order = $orderDao->getCurrentOrder();

        // Simulation : l'utilisateur entre un code promo
        $promotion = $promotionDao->getPromotionByName();
        $order->setPromotion($promotion);

        // Validation de la promotion
        $promotionValidatorError = null;
        try {
            $promotionRulesValidator->validatePromotion($order);
        } catch(PromotionValidationRuleException $e) {
            $promotionValidatorError = $e->getMessage();
        }


        return $this->render('cart/details.html.twig', [
            'order' => $order,
        ]);
    }
}
