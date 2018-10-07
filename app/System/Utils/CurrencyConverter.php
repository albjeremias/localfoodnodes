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
        $this->currencies = DB::table('currencies')->get()->keyBy('currency');
    }

    /**
     * Convert amount to a different currency.
     *
     * @param int $amount
     * @param string $from
     * @param string $to
     * @return int
     */
    public function convert($amount, $from, $to = 'EUR')
    {
        if (!$from || !$to) {
            return null;
        }

        $fromObj = $this->currencies->get($from);
        $toObj = $this->currencies->get($to);

        if ($fromObj && $toObj) {
            $fromRate = $fromObj->rate;
            $toRate = $toObj->rate;

            $convertedAmount = $amount / $fromRate;

            if ($toObj->currency !== 'EUR') {
                $convertedAmount = $convertedAmount * $toRate;
            }

            return $convertedAmount;
        } else {
            throw new \Exception('Currency ' . $from . ' or ' . $to . ' does not exist');
        }
    }
}
