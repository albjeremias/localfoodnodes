<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

use App\System\Parsers\TransactionParser\Transaction;
use App\System\Utils\CurrencyConverter;
use App\Node\Node;
use App\Helpers\MapHelper;

class PublicApiController extends ApiBaseController
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
        $transactions = Transaction::orderByDesc('date')->get();

        $currencyConverter = null;
        if ($request->has('currency')) {
            $currencyConverter = new CurrencyConverter();
        }

        $economyCategories = $this->getEconomyCategories();
        $incomeCategories = new Collection($economyCategories['income']);
        $costCategories = new Collection($economyCategories['cost']);
        $allCategories = $incomeCategories->concat($costCategories);

        // All categories
        $availableYears = [];
        $income = 0;
        $cost = 0;
        foreach ($transactions as $transaction) {
            $availableYears[$transaction->year] = $transaction->year;
            $amount = $transaction->amount;

            if ($request->has('currency')) {
                $amount = (int) $currencyConverter->convert($amount, 'EUR', $request->get('currency'));
            }

            if ($incomeCategories->contains('id', $transaction->category)) {
                $income += $amount;
            } else if ($costCategories->contains('id', $transaction->category)) {
                $cost += -$amount;
            }
        }

        // Filter by provided year
        if ($request->has('year')) {
            $yearStart = $request->get('year') . '-01-01 00:00:00';
            $yearEnd = $request->get('year') . '-12-31 23:59:59';
            $transactions = $transactions->filter(function($transaction) use ($yearStart, $yearEnd) {
                return ($transaction->date >= $yearStart && $transaction->date <= $yearEnd);
            });
        }

        // Calculate sums based on year filter
        $incomeFiltered = 0;
        $costFiltered = 0;
        $totalFilteredPerCategory = [];
        foreach ($transactions as $transaction) {
            $amount = $transaction->amount;

            if ($request->has('currency')) {
                $amount = (int) $currencyConverter->convert($amount, 'EUR', $request->get('currency'));
            }

            if (!isset($totalFilteredPerCategory[$transaction->category])) {
                $totalFilteredPerCategory[$transaction->category] = 0;
            }

            if ($transaction->category) {
                $totalFilteredPerCategory[$transaction->category] += $amount;
            }

            if ($incomeCategories->contains('id', $transaction->category)) {
                $incomeFiltered += $amount;
            } else if ($costCategories->contains('id', $transaction->category)) {
                $costFiltered += -$amount;
            }
        }

        rsort($availableYears);

        // Format chart data
        $chartData = [];
        foreach ($allCategories as $category) {
            $categoryId = $category['id'];
            $categoryName = trans('public-api.metrics.category_' . $categoryId);
            $group = null;

            if ($incomeCategories->contains('id', $categoryId)) {
                $group = 'income';
            } else if ($costCategories->contains('id', $categoryId)) {
                $group = 'cost';
            }

            if ($group) {
                $chartData[$group][] = [
                    $categoryName,
                    isset($totalFilteredPerCategory[$categoryId]) ? abs($totalFilteredPerCategory[$categoryId]) : 0
                ];
            }
        }

        // Chart headers
        array_unshift($chartData['income'], ['Category', 'Amount']);
        array_unshift($chartData['cost'], ['Category', 'Amount']);

        $data = [
            'categories' => [
                'all' => $allCategories,
                'income' => $incomeCategories->pluck('id'),
                'cost' => $costCategories->pluck('id'),
            ],
            'filter' => [
                'category' => $request->get('category'),
                'currency' => $request->has('currency') ? $request->get('currency') : 'EUR',
                'year' => $request->has('year') ? $request->get('year') : null,
            ],
            'transactions' => [
                'all' => $transactions,
                'allGrouped' => $transactions->groupBy('category'),
                'income' => $transactions->whereIn('category', $incomeCategories->pluck('id'))->groupBy('category'),
                'cost' => $transactions->whereIn('category', $costCategories->pluck('id'))->groupBy('category'),
            ],
            'total' => [
                'income' => $incomeFiltered,
                'cost' => $costFiltered,
                'grouped' => $totalFilteredPerCategory,
                'diff' => (int) ($income - $cost),
            ],
            'chartData' => $chartData,
            'years' => $availableYears,
        ];

        return response()->json($data);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    private function getEconomyCategories() {
        // Economy categories
        return [
            'income' => [
                ['id' => 1, 'label' => trans('public-api.metrics.category_1'), 'type_label' => 'Income - Membership'],
                ['id' => 2, 'label' => trans('public-api.metrics.category_2'), 'type_label' => 'Income - Other'],
            ],
            'cost' => [
                ['id' => 3, 'label' => trans('public-api.metrics.category_3'), 'type_label' => 'Cost - Operation'],
                ['id' => 4, 'label' => trans('public-api.metrics.category_4'), 'type_label' => 'Cost - Saleries'],
                ['id' => 5, 'label' => trans('public-api.metrics.category_5'), 'type_label' => 'Cost - Other'],
            ]
        ];
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
