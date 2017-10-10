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
            'pieces' => trans_choice('units.pieces', 2),
            'bag' => trans_choice('units.bag', 2),
            'bottle' => trans_choice('units.bottle', 2),
            'jar' => trans_choice('units.jar', 2),

            // Weight
            'kg' => trans('units.kg'),
            'hg' => trans('units.hg'),
            'g' => trans('units.g'),
            'lb' => trans('units.pound'),
            'oz' => trans('units.oz'),
            'gr' => trans('units.gr'),

            // Volume
            'l' => trans('units.l'),
            'dl' => trans('units.dl'),
            'cl' => trans('units.cl'),
            'ml' => trans('units.ml'),
            'floz' => trans('units.floz'),
            'pint' => trans('units.pint'),
            'gallon' => trans('units.gallon'),
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
