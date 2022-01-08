<?php

namespace App\DataProvider;

use App\Entity\Brand;
use App\Entity\Item;
use App\Entity\Product;
use App\Entity\Order;
use App\Entity\Promotion;
use App\Entity\ShippingFee\FixedShippingFee;
use App\Entity\ShippingFee\PackagedShippingFee;
use App\Entity\Vat\FixedVat;

class OrderDao
{
    /**
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
            new PackagedShippingFee(3, 20.0),
            new FixedVat(20.0)
        );
        $gallagher = new Brand(
            'Gallagher',
            new FixedShippingFee(15.0),
            new FixedVat(5.0)
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
}