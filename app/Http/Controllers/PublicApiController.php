<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

use App\System\Parsers\TransactionParser\Transaction;
use App\System\Utils\CurrencyConverter;
use App\Node\Node;
use App\Node\Reko;
use App\Helpers\MapHelper;

class PublicApiController extends BaseController
{
    /**
     * Translations endpoint.
     *
     * @param Request $request
     * @return void
     */
    public function translations(Request $request)
    {
        if (!$request->has('keys')) {
            return response()->json($this->error('Missing keys.'));
        }

        $keys = explode(',', $request->get('keys'));
        $translations = [];
        foreach ($keys as $key) {
            $translationKey = 'public-api.' . $key;
            $translations += trans($translationKey);
        }

        $res = $this->error('Could not find translation.');
        if ($translations !== $translationKey) {
            $res = ['data' => $translations];
        }

        return response()->json($res);
    }

    /**
     * Translations endpoint.
     *
     * @param Request $request
     * @return void
     */
    public function currencies(Request $request)
    {
        if ($request->has('all')) {
            $currencies = DB::table('currencies')->get()->keyBy('currency');
        } else {
            $currencies = DB::table('currencies')->where('enabled', true)->get()->keyBy('currency');
        }

        return response()->json($currencies);
    }

    /**
     * Get all map contents.
     *
     * Initial load: show x nodes closest to user location
     * On search: show the (one) node closest to searched location
     * On zoom: Load nodes within bountries
     *
     * @param Request $request
     * @return array
     */
    public function nodes(Request $request)
    {
        $mapHelper = new MapHelper();

        if ($request->has('bounds')) {
            $bounds = $request->input('bounds');
            $nodes = $mapHelper->getNodesByBounds($bounds);
        } else {
            $nodes = Node::all();
        }

        return response()->json([
            'nodes' => $nodes,
        ]);
    }

    /**
     * Get all transactions.
     *
     * @param  Request $request
     * @return Collection
     */
    public function transactions(Request $request)
    {
        $currencyConverter = null;
        if ($request->has('currency')) {
            $currencyConverter = new CurrencyConverter();
        }

        $incomeCategories = new Collection(config('economy.categories.income'));
        $costCategories = new Collection(config('economy.categories.cost'));

        $transactions = Transaction::orderByDesc('date')->get();

        $totalIncome = 0;
        $totalCost = 0;

        foreach ($transactions as $transaction) {
            $amount = $transaction->amount;

            if ($request->has('currency')) {
                $amount = $currencyConverter->convert($amount, 'EUR', $request->get('currency'));
                $transaction->amount = $amount;
            }

            if ($incomeCategories->contains('id', $transaction->category)) {
                $totalIncome += (int) $transaction->amount;
            } else if ($costCategories->contains('id', $transaction->category)) {
                $totalCost += (int) -$transaction->amount;
            }
        }

        $data = [
            'transactions' => $transactions,
            'categories' => [
                'all' => $incomeCategories->concat($costCategories),
                'income' => $incomeCategories->pluck('id'),
                'cost' => $costCategories->pluck('id'),
            ],
            'total' => [
                'income' => $totalIncome,
                'cost' => $totalCost
            ]
        ];

        return response()->json($data);
    }

    /**
     * Format error messages
     *
     * @param string $message
     * @return void
     */
    private function error($message)
    {
        return [
            'error' => [
                'message' => $message
            ]
        ];
    }
}
