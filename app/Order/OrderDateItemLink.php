<?php

namespace App\Order;

use Illuminate\Database\Eloquent\Collection;

class OrderDateItemLink extends \App\BaseModel
{
    // protected $with = ['orderItemRelationship', 'orderDateRelationship'];

    /**
     * Validation rules.
     *
     * @var array
     */
    protected $validationRules = [
        'user_id' => 'required',
        'producer_id' => 'required',
        'order_item_id' => 'required',
        'order_date_id' => 'required',
        'quantity' => 'required',
        'amount' => '',
        'currency' => '',
        'ref' => 'required',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'producer_id',
        'order_item_id',
        'order_date_id',
        'quantity',
        'amount',
        'currency',
        'ref',
    ];

    /**
     * Lifecycle events.
     */
    protected static function boot() {
        parent::boot();

        static::deleting(function($orderDateItemLink) {
            $orderDateItemLink->getItem()->delete();
        });
    }

    /**
     * Define relationship with order items.
     *
     * @return Collection
     */
    public function orderItemRelationship()
    {
        return $this->hasMany('App\Order\OrderItem', 'id', 'order_item_id');
    }

    /**
     * Get order item.
     *
     * @return OrderItem
     */
    public function getItem()
    {
        return $this->orderItemRelationship->first();
    }

    /**
     * Define relationship with order dates.
     *
     * @return OrderDate
     */
    public function orderDateRelationship()
    {
        return $this->hasMany('App\Order\OrderDate', 'id', 'order_date_id');
    }

    /**
     * Get order date.
     *
     * @return OrderDate
     */
    public function getDate()
    {
        return $this->orderDateRelationship->first();
    }

    /**
    * Get item price.
    *
    * @return int
    */
    public function getPrice($inclVat = true)
    {
        $price = $this->getItem()->variant ?  $this->getItem()->variant['price'] : $this->getItem()->product['price'];

        if ($this->getItem()->product['production_type'] === 'csa') {
            $csaPrice = $price;
            $price = round($this->quantity * $price);
        } else if (\UnitsHelper::isStandardUnit($this->getItem()->product['price_unit'])) {
            // Sold by weight
            if ($this->getItem()->variant) {
                $variant = $this->getItem()->variant;
                $packageAmount = isset($variant['package_amount']) ? $variant['package_amount'] : 1;

                $price = $price * $this->quantity * $packageAmount;
            } else {
                $product = $this->getItem()->product;
                $packageAmount = isset($product['package_amount']) ? $product['package_amount'] : 1;

                $price = $price * $this->quantity * $packageAmount;
            }
        } else {
            // Sold by product
            $price = $price * $this->quantity;
        }

        if (!$inclVat) {
            $vat = $this->getItem()->getProduct()->vat;
            if ($vat) {
                $price = $price - ($price * ($vat * 100));
            }
        }

        return $price;
    }

    /**
     * Get unit.
     *
     * @return string
     */
    public function getUnit()
    {
        return $this->getItem()->producer['currency'];
    }

    /**
     * Get price unit.
     *
     * @return string
     */
    public function getPriceWithUnit($inclVat = true)
    {
        $prefix = '';
        if (\UnitsHelper::isStandardUnit($this->getItem()->product['price_unit'])) {
            $prefix = '<span class="approx">&asymp;</span>';
        }

        $csa = '';
        if ($this->getItem()->product['production_type'] === 'csa') {
            $csa = ' <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Price is for the entire CSA"></i>';
        }

        return $prefix . ' ' . $this->getPrice($inclVat) . ' ' . $this->getUnit() . $csa;
    }

    /**
     * Get the vat amount from the price with unit.
     *
     * @return string
     */
    public function getVatAmountWithUnit()
    {
        $vat = $this->getItem()->getProduct()->vat;
        $priceExclVat = $this->getPrice() / (($vat / 100) + 1);
        $vatAmount = $this->getPrice() - $priceExclVat;

        $prefix = '';
        if (\UnitsHelper::isStandardUnit($this->getItem()->product['price_unit'])) {
            $prefix = '<span class="approx">&asymp;</span>';
        }

        return $prefix . ' ' . round($vatAmount, 2) . ' ' . $this->getUnit();
    }

    /**
     * Check if order is deletable.
     *
     * @return boolean
     */
    public function isDeletable()
    {
        // If date is missing, fix for bad data
        if (!$this->getDate()) {
            return true;
        }

        $product = $this->getItem()->getProduct();

        $productDeadline = new \DateTime();
        if ($product['deadline']) {
            $productDeadline->modify('+' . $product['deadline'] . ' days');
        }

        $orderDeliveryDate = $this->getDate()->date;
        $interval = $productDeadline->diff($orderDeliveryDate);

        return (int) $interval->format('%r%a') < 0 ? false : true;
    }
}
