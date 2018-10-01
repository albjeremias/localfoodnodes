<?php

namespace App\System\StatisticsGenerator\Generators;

use Illuminate\Support\Facades\DB;

use App\System\StatisticsGenerator\Generators\BaseGenerator;
use App\Producer\Producer;

class ProducerGenerator extends BaseGenerator
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
     * Generate producer count.
     *
     * @return void
     */
    public function count()
    {
        $total = Producer::count();
        $query = ['key' => 'producer_count', 'data' => $total];
        $this->insertOrUpdate($query);
    }
}