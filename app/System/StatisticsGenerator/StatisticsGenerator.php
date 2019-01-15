<?php

namespace App\System\StatisticsGenerator;

use Illuminate\Support\Facades\DB;

use App\System\Utils\CurrencyConverter;
use App\System\StatisticsGenerator\Generators\DeliveryGenerator;
use App\System\StatisticsGenerator\Generators\NodeGenerator;
use App\System\StatisticsGenerator\Generators\OrderGenerator;
use App\System\StatisticsGenerator\Generators\ProducerGenerator;
use App\System\StatisticsGenerator\Generators\ProductGenerator;
use App\System\StatisticsGenerator\Generators\UserGenerator;

class StatisticsGenerator
{
    private $currencyConverter;

    /**
     * Constructor.
     */
    public function __construct(CurrencyConverter $currencyConverter)
    {
        $this->deliveryGenerator = new DeliveryGenerator($currencyConverter);
        $this->orderGenerator = new OrderGenerator($currencyConverter);
        $this->nodeGenerator = new NodeGenerator();
        $this->producerGenerator = new ProducerGenerator();
        $this->productGenerator = new ProductGenerator();
        $this->userGenerator = new UserGenerator($currencyConverter);
    }

    /**
     * Run generators
     */
    public function generate($type = null)
    {
        if ($type === 'order') {
            $this->orderGenerator->generate();
        } else {
            $this->deliveryGenerator->generate();
            $this->nodeGenerator->generate();
            $this->producerGenerator->generate();
            $this->productGenerator->generate();
            $this->userGenerator->generate();
        }
    }
}