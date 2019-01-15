<?php

namespace App\System\Importers;

use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class CurrencyRateImporter
{
    private $rateUrl = 'http://data.fixer.io/api/latest?access_key=%s';
    private $symbolUrl = 'http://data.fixer.io/api/symbols?access_key=%s';

    public function import()
    {
        $values = [];
        $client = new Client();

        $dbCurrencies = DB::table('currencies')->get()->keyBy('currency');

        // Import latest rates
        $rateUrl = sprintf($this->rateUrl, config('services.fixer.api_access_key'));
        $res = $client->request('GET', $rateUrl);
        $json = json_decode($res->getBody());

        foreach ((array) $json->rates as $currency => $rate) {
            $dbCurrency = $dbCurrencies->get($currency);
            $values[$currency] = [
                'currency' => $currency,
                'rate' => $rate,
                'enabled' => $dbCurrency ? $dbCurrency->enabled : false,
                'updated' => date('Y-m-d H:i:s'),
            ];
        };

        // Import symbols
        $symbolUrl = sprintf($this->symbolUrl, config('services.fixer.api_access_key'));
        $res = $client->request('GET', $symbolUrl);
        $json = json_decode($res->getBody());

        foreach ((array) $json->symbols as $currency => $symbol) {
            if (isset($values[$currency])) {
                $values[$currency]['label'] = $symbol;
            }
        };

        // Insert or update
        foreach ($values as $currency => $value) {
            if ($dbCurrencies->has($currency)) {
                DB::table('currencies')->where('currency', $currency)->update($value);
            } else {
                DB::table('currencies')->insert($value);
            }
        }
    }
}