<?php

namespace App\System\StatisticsGenerator\Generators;

use Illuminate\Support\Facades\DB;

class BaseGenerator
{
    /**
     * Helper function that does inserts or updates to database.
     *
     * @param array $query
     * @return void
     */
    protected function insertOrUpdate($query)
    {
        $query['updated'] = date('Y-m-d H:i:s');

        try {
            DB::table('statistics')->insert($query);
        } catch (\Exception $e) {
            DB::table('statistics')
            ->where('key', $query['key'])
            ->update($query);
        }
    }
}