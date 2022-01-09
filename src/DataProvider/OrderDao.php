<?php

namespace App\DataProvider;

use App\Entity\Brand;
use App\Entity\Item;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\ShippingFee\PackagedShippingFee;
use App\Entity\ShippingFee\ShippingFee;
use App\Entity\Vat\Vat;

/**
 * Récupération des données (en dur ici mais possiblement depuis API ou BDD)
 */
class OrderDao
{
    /**
     * Récupération de l'order en cours
     * @return Order
     */
    public function getCurrentOrder(): Order
    {
        // Je passe une commande avec
        // Cuve à gasoil x1
        // Nettoyant pour cuve x3
        // Piquet de clôture x5

        $farmitoo = new Brand(
            'Farmitoo',
            new PackagedShippingFee(20.0, 3),
            new Vat(20.0)
        );
        $gallagher = new Brand(
            'Gallagher',
            new ShippingFee(15.0),
            new Vat(5.0)
        );

        $product1 = new Product('Cuve à gasoil', 250000.0, $farmitoo);
        $product2 = new Product('Nettoyant pour cuve', 5000.0, $farmitoo);
        $product3 = new Product('Piquet de clôture', 1000.50, $gallagher);

        $currentOrder = new Order([
            new Item($product1, 1),
            new Item($product2, 3),
            new Item($product3, 5)
        ],
        new \DateTime());

        return $currentOrder;
    }
    /**
     * @return Order
     */
    public function getOtherOrder(): Order
    {
        $farmitoo = new Brand(
            'Farmitoo',
            new PackagedShippingFee(20.0, 3),
            new Vat(20.0)
        );
        $gallagher = new Brand(
            'Gallagher',
            new ShippingFee(15.0),
            new Vat(5.0)
        );
        $lely = new Brand(
            'Lely',
            new PackagedShippingFee(150.0, 1),
            new Vat(10)
        );
        $johnDeere = new Brand(
            'John Deere',
            new ShippingFee(450.0),
            new Vat(15)
        );

        $product1 = new Product('Cuve à gasoil', 1250.0, $farmitoo);
        $product2 = new Product('Nettoyant pour cuve', 100.0, $farmitoo);
        $product3 = new Product('Piquet de clôture', 5.50, $gallagher);
        $product4 = new Product('8R 410', 500000.00, $johnDeere);
        $product5 = new Product('Robot de traite', 15500.00, $lely);

        $currentOrder = new Order([
            new Item($product1, 1),
            new Item($product2, 5),
            new Item($product3, 50),
            new Item($product4, 1),
            new Item($product5, 2)
        ],
            new \DateTime());

        return $currentOrder;
    }
}