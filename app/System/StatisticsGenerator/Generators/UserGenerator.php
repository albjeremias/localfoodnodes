<?php

namespace App\System\StatisticsGenerator\Generators;

use Illuminate\Support\Facades\DB;

use App\System\StatisticsGenerator\Generators\BaseGenerator;
use App\System\Utils\CurrencyConverter;
use App\User\User;
use App\User\UserMembershipPayment;

class UserGenerator extends BaseGenerator
{
    private $currencyConverter;

    /**
     * Constructor.
     *
     * @param CurrencyConverter $currencyConverter
     */
    public function __construct(CurrencyConverter $currencyConverter)
    {
        $this->currencyConverter = $currencyConverter;
    }

    /**
     * Run scripts.
     *
     * @return void
     */
    public function generate()
    {
        $this->count();
        $this->countPerDate();
        $this->members();
        $this->averageAmount();
    }

    /**
     * Generate user count.
     *
     * @return void
     */
    public function count()
    {
        $total = User::count();
        $query = ['key' => 'user_count', 'data' => $total];
        $this->insertOrUpdate($query);
    }

    /**
     * Generate user count per date.
     *
     * @return void
     */
    public function countPerDate()
    {
        $rows = Db::table('users')
        ->select(DB::raw('DATE_FORMAT(created_at, \'%Y-%m-%d\') AS date, count(DATE_FORMAT(created_at, \'%Y-%m-%d\')) AS count'))
        ->groupBy('date')
        ->get();

        $countPerDate = [];
        foreach ($rows as $row) {
            $countPerDate[$row->date] = $row->count;
        }

        $query = ['key' => 'user_count_per_date', 'data' => json_encode($countPerDate)];
        $this->insertOrUpdate($query);
    }

    /**
     * Generate payment users count
     *
     * @return void
     */
    public function members()
    {
        $row = DB::table('user_membership_payments')
        ->select(DB::raw('count(DISTINCT user_id) AS count'))
        ->first();

        $query = ['key' => 'user_members_count', 'data' => $row->count];
        $this->insertOrUpdate($query);
    }

    /**
     * Generate average membership amount
     *
     * @return void
     */
    public function averageAmount()
    {
        $payments = UserMembershipPayment::all();

        $filteredAmounts = [];
        $amount = [];
        foreach ($payments as $payment) {
            $convertedAmount = $this->currencyConverter->convert($payment->amount, $payment->currency);
            $amount[] = $convertedAmount;

            if ($convertedAmount > 1) {
                $filteredAmount[] = $convertedAmount;
            }
        }

        $average = array_sum($amount) / count($amount);
        $filteredAverage = array_sum($filteredAmount) / count($filteredAmount);

        $this->insertOrUpdate(['key' => 'user_average_amount', 'data' => $average]);
        $this->insertOrUpdate(['key' => 'user_average_amount_filtered', 'data' => $filteredAverage]);
    }
}