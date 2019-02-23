<?php

namespace App\Product;

use App\BaseModel;

class ProductVariant extends BaseModel
{
    /**
     * Validation rules.
     *
     * @var array
     */
    protected $validationRules = [
        'product_id' => 'required',
        'name' => 'required|max:255',
        'price' => 'required|integer',
        'package_amount' => 'required|integer|min:0.01',
        'main_variant' => 'boolean',
        'quantity' => 'nullable|integer'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'name',
        'price',
        'package_amount',
        'main_variant',
        'quantity',
    ];

    /**
     * Lifecycle events.
     */
    protected static function boot() {
        parent::boot();

        static::saving(function($variant) {
            $variant->package_amount = (float) str_replace(',', '.', $variant->package_amount);
        });
    }

    /**
     * Get product.
     *
     * @return App\Product\Product
     */
    public function getProduct()
    {
        return $this->hasOne('App\Product\Product', 'id', 'product_id')->first();
    }

    /**
     * Define product relationship with node delivery links.
     */
    public function deliveryLinksRelationship()
    {
        return $this->hasMany('App\Product\ProductNodeDeliveryLink');
    }

    // /**
    //  * Get production quantity.
    //  *
    //  * @return int
    //  */
    // public function getProductionQuantity()
    // {
    //     if (!$this->package_amount) {
    //         return 0;
    //     }

    //     $smallestCommonDenominator = $this->getProduct()->getProductionQuantity() / $this->package_amount;
    //     $quantity = $smallestCommonDenominator * $this->getProduct()->mainVariant()->package_amount;

    //     return floor($quantity);
    // }

    /**
     * Get package amount.
     *
     * @return string
     */
    public function getPackageAmountUnit()
    {
        if ($this->getProduct()->package_unit) {
            return '(' . $this->package_amount . ' ' . trans_choice('units.' . $this->getProduct()->package_unit, $this->package_amount) . ')';
        }
    }

    /**
     * Get product variant unit.
     *
     * @return string
     */
    public function getUnit()
    {
        $product = $this->getProduct();

        if (\UnitsHelper::isStandardUnit($product->price_unit)) {
            return $product->producer()->currency . '/' . $product->price_unit;
        } else {
            return $product->producer()->currency;
        }
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getPriceAttribute($price)
    {
        if ($this->main_variant) {
            return $this->getProduct()->price;
        }

        return $price;
    }

    /**
     * Get price with unit.
     *
     * @return string
     */
    public function getPriceWithUnit()
    {
        return $this->price . ' ' . $this->getUnit();
    }

    /**
     * Get price and unit html.
     *
     * @return string
     */
    public function getPriceWithUnitHtml()
    {
        $prefix = '';
        if (\UnitsHelper::isStandardUnit($this->price_unit)) {
            $prefix = '<span class="approx">&asymp;</span>';
        }

        return '<h3 class="price">' . $prefix . $this->price . '</h3><div class="unit">' . $this->getUnit() . '</div>';
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function getQuantityAttribute($quantity)
    {
        if ($this->main_variant) {
            return $this->getProduct()->stock_quantity;
        }

        return $quantity;
    }

    /**
     * Get info to be stored with order.
     *
     * @return array
     */
    public function getInfoForOrder()
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'name' => $this->name,
            'price' => $this->price,
            'package_amount' => $this->package_amount,
            'main_variant' => $this->main_variant,
        ];
    }
}
