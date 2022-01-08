<?php

namespace App\Entity;

use App\Entity\ShippingFee\ShippingFeeInterface;
use App\Entity\Vat\VatInterface;

class Brand
{
    /** @var string */
    protected $name;

    /** @var ShippingFeeInterface */
    protected $shippingFee;

    /** @var VatInterface */
    protected $vat;

    /**
     * @param string $name
     * @param ShippingFeeInterface $shippingFee
     * @param VatInterface $vat
     */
    public function __construct(string $name, ShippingFeeInterface $shippingFee, VatInterface $vat)
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
     * @return ShippingFeeInterface
     */
    public function getShippingFee(): ShippingFeeInterface
    {
        return $this->shippingFee;
    }

    /**
     * @param ShippingFeeInterface $shippingFee
     * @return Brand
     */
    public function setShippingFee(ShippingFeeInterface $shippingFee): Brand
    {
        $this->shippingFee = $shippingFee;
        return $this;
    }

    /**
     * @return VatInterface
     */
    public function getVat(): VatInterface
    {
        return $this->vat;
    }

    /**
     * @param VatInterface $vat
     * @return Brand
     */
    public function setVat(VatInterface $vat): Brand
    {
        $this->vat = $vat;
        return $this;
    }
}