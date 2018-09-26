<?php

namespace App\System\Utils;

use Illuminate\Support\Facades\DB;

class CurrencyConverter
{
    // Currency rates
    private $currencies;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->currencies = DB::table('currencies')->get();
    }

    /**
     * Convert amount to a different currency.
     *
     * @param int $amount
     * @param string $from
     * @param string $to
     * @return int
     */
    public function convert($amount, $from, $to = null)
    {
        if (!$from || !$to) {
            return null;
        }

        $fromRate = $this->currencies->where('currency', $from)->first()->rate;
        $toRate = $this->currencies->where('currency', $to)->first()->rate;
        $convertedAmount = $amount / $fromRate;

        if ($to) {
            $convertedAmount = $convertedAmount * $toRate;
        }

        return $convertedAmount;
    }
}
