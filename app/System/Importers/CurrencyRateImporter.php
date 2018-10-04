<?php

namespace App\System\Importers;

use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class CurrencyRateImporter
{
    private $url = 'http://data.fixer.io/api/latest?access_key=%s';

    public function import()
    {
        $client = new Client();
        $url = sprintf($this->url, config('services.fixer.api_access_key'));
        $res = $client->request('GET', $url);
        $json = json_decode($res->getBody());

        $values = [];
        foreach ((array) $json->rates as $currency => $rate) {
            $values[] = [
                'currency' => $currency,
                'rate' => $rate,
                'updated' => date('Y-m-d H:i:s')
            ];
        };

        if (!empty($values)) {
            DB::table('currencies')->truncate();
            DB::table('currencies')->insert($values);
        }
    }
}