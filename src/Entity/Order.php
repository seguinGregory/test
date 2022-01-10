<?php


namespace App\Entity;

use App\Entity\Item;
use App\Entity\Promotion;

class Order
{
    /** @var Item[] */
    protected $items;

    /** @var \DateTime */
    protected $submissionDate;

    /** @var string Format : Code Alpha3 */
    protected $billingCountry;

    /** @var Promotion|null */
    protected $promotion;

    /**
     * @param Item[] $items
     * @param \DateTime $submissionDate
     * @param string $billingCountry
     */
    public function __construct(array $items, \DateTime $submissionDate, string $billingCountry)
    {
        $this->items = $items;
        $this->submissionDate = $submissionDate;
        $this->billingCountry = $billingCountry;
    }

    /**
     * @return Item[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param Item[] $items
     * @return Order
     */
    public function setItems(array $items): Order
    {
        $this->items = $items;
        return $this;
    }

    /**
     * @param Item $item
     * @return $this
     */
    public function addItem(Item $item): Order {
        $this->items[] = $item;
        return $this;
    }

    /**
     * @param Item $item
     * @return $this
     */
    public function removeItem(Item $item): Order {
        if($index = array_search($item, $this->items) !== false) {
            array_splice($this->items, $index, 1);
        }
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getSubmissionDate(): \DateTime
    {
        return $this->submissionDate;
    }

    /**
     * @param \DateTime $submissionDate
     * @return Order
     */
    public function setSubmissionDate(\DateTime $submissionDate): Order
    {
        $this->submissionDate = $submissionDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getBillingCountry(): string
    {
        return $this->billingCountry;
    }

    /**
     * @param string $billingCountry
     * @return Order
     */
    public function setBillingCountry(string $billingCountry): Order
    {
        $this->billingCountry = $billingCountry;
        return $this;
    }

    /**
     * @return Promotion|null
     */
    public function getPromotion(): ?Promotion
    {
        return $this->promotion;
    }

    /**
     * @param Promotion|null $promotion
     * @return Order
     */
    public function setPromotion(?Promotion $promotion): Order
    {
        $this->promotion = $promotion;
        return $this;
    }

    /**
     * Récupération du nombre total d'article dans la commande
     * @return int
     */
    public function getProductQuantity(): int
    {
        $productQuantity = 0;

        foreach($this->items AS $item) {
            $productQuantity += $item->getQuantity();
        }

        return $productQuantity;
    }
}
