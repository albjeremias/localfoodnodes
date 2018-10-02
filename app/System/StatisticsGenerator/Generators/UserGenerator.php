<?php

namespace App\System\StatisticsGenerator\Generators;

use Illuminate\Support\Facades\DB;

use App\System\StatisticsGenerator\Generators\BaseGenerator;
use App\User\User;

class UserGenerator extends BaseGenerator
{
    /**
     * Run scripts.
     *
     * @return void
     */
    public function generate()
    {
        $this->count();
        $this->members();
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
}