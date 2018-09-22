<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class CurrencyHelper
{
    public function convert($amount, $from, $to = null)
    {
        if (!$from || !$to) {
            return null;
        }

        $currencies = DB::table('currencies')
        ->select('currency', 'rate')
        ->where('currency', $from)
        ->orWhere('currency', $to)
        ->get();

        $fromRate = $currencies->where('currency', $from)->first()->rate;
        $toRate = $currencies->where('currency', $to)->first()->rate;
        $convertedAmount = $amount / $fromRate;

        if ($to) {
            $convertedAmount = $convertedAmount * $toRate;
        }

        return $convertedAmount;
    }
}
