<?php

namespace App\Controller;

use App\DataProvider\OrderDao;
use App\DataProvider\PromotionDao;
use App\Exception\PromotionValidationRuleException;
use App\Service\Price\Calculator;
use App\Validator\PromotionRulesValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(
        OrderDao $orderDao,
        PromotionDao $promotionDao,
        PromotionRulesValidator $promotionRulesValidator,
        Calculator $priceCalculator,
        \App\Service\ShippingFee\Calculator $shippingFeeCalculator
    ): Response
    {
        $order = $orderDao->getCurrentOrder();
        //$order = $orderDao->getOtherOrder();

        // Simulation : l'utilisateur entre un code promo existant
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
            'title' => 'Votre panier : ' . count($order->getItems()) . ' produit(s)',
            'order' => $order,
            'priceCalculator' => $priceCalculator,
            'shippingFeeCalculator' => $shippingFeeCalculator,
            'promotionValidatorError' => $promotionValidatorError
        ]);
    }

    /**
     * @Route("/payment", name="payment")
     */
    public function payment() {
        return new Response('Offert par la maison :D');
    }
}
