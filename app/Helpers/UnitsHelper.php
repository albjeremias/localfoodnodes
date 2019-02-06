<?php

namespace App\Helpers;

class UnitsHelper
{
    /**
     * Get variant units.
     *
     * @return Collection
     */
    public static function getVariantUnits()
    {
        return collect([
            // Items
            'pieces' => trans_choice('piece|pieces', 2),
            'bag' => trans_choice('bag|bags', 2),
            'bottle' => trans_choice('bottle|bottles', 2),
            'jar' => trans_choice('jar|jars', 2),

            // Weight
            'kg' => __('kg'),
            'hg' => __('hg'),
            'g' => __('g'),
            'lb' => __('pound'),
            'oz' => __('oz'),
            'gr' => __('gr'),

            // Volume
            'l' => __('l'),
            'dl' => __('dl'),
            'cl' => __('cl'),
            'ml' => __('ml'),
            'floz' => __('floz'),
            'pint' => __('pint'),
            'gallon' => __('gallon'),
        ]);
    }

    /**
     * Get price units.
     *
     * @return Collection
     */
    public static function getPriceUnits()
    {
        return collect([
            'product' => trans_choice('admin/product.product', 1),
            'kg' => trans('admin/product.kg'),
            'hg' => trans('admin/product.hg'),
            'lb' => trans('units.lb'),
            'oz' => trans('units.oz'),
            'gr' => trans('units.gr'),
        ]);
    }

    /**
     * Check if unit is a standard unit. These units are used for calculating stock.
     *
     * @param string $unit
     * @return boolean
     */
    public static function isStandardUnit($unit)
    {
        return in_array($unit, [
            'kg', 'hg', 'g',
            'l', 'dl', 'cl', 'ml',
            'lb', 'oz', 'gr',
            'floz', 'pint', 'gallon',
        ]);
    }

    /**
     * Get currencies.
     *
     * @return Collection
     */
    public static function getCurrencies()
    {
        return collect([
            'CAD',
            'CHF',
            'CNY',
            'CZK',
            'DKK',
            'EUR',
            'GBP',
            'HKD',
            'HUF',
            'IDR',
            'INR',
            'ISK',
            'JPY',
            'KRW',
            'MAD',
            'MXN',
            'NOK',
            'PLN',
            'RUB',
            'SAR',
            'SEK',
            'SGD',
            'THB',
            'TRY',
            'USD',
            'ZAR',
        ]);
    }
}
