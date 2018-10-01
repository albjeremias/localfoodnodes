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
        $this->nodeGenerator = new NodeGenerator();
        $this->orderGenerator = new OrderGenerator($currencyConverter);
        $this->producerGenerator = new ProducerGenerator();
        $this->productGenerator = new ProductGenerator();
        $this->userGenerator = new UserGenerator();
    }

    /**
     * Run generators
     */
    public function generate()
    {
        $this->deliveryGenerator->generate();
        $this->nodeGenerator->generate();
        $this->orderGenerator->generate();
        $this->producerGenerator->generate();
        $this->productGenerator->generate();
        $this->userGenerator->generate();
    }
}