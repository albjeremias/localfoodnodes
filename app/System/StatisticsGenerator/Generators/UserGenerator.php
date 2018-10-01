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
}