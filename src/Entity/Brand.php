<?php

namespace App\Entity;

use App\Entity\ShippingFee\ShippingFee;
use App\Entity\Vat\Vat;

class Brand
{
    /** @var string */
    protected $name;

    /** @var ShippingFee */
    protected $shippingFee;

    /** @var Vat */
    protected $vat;

    /**
     * @param string $name
     * @param ShippingFee $shippingFee
     * @param Vat $vat
     */
    public function __construct(string $name, ShippingFee $shippingFee, Vat $vat)
    {
        $this->name = $name;
        $this->shippingFee = $shippingFee;
        $this->vat = $vat;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Brand
     */
    public function setName(string $name): Brand
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return ShippingFee
     */
    public function getShippingFee(): ShippingFee
    {
        return $this->shippingFee;
    }

    /**
     * @param ShippingFee $shippingFee
     * @return Brand
     */
    public function setShippingFee(ShippingFee $shippingFee): Brand
    {
        $this->shippingFee = $shippingFee;
        return $this;
    }

    /**
     * @return Vat
     */
    public function getVat(): Vat
    {
        return $this->vat;
    }

    /**
     * @param Vat $vat
     * @return Brand
     */
    public function setVat(Vat $vat): Brand
    {
        $this->vat = $vat;
        return $this;
    }
}