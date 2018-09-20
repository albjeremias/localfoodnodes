<?php

namespace App\System;

use Illuminate\Support\Facades\DB;

use App\Order\OrderDateItemLink;
use App\User\User;
use App\Producer\Producer;
use App\Node\Node;

class StatisticsGenerator
{
    public function totalOrderAmount()
    {
        $orderDateItemLinks = OrderDateItemLink::all();
        $total = $orderDateItemLinks->sum(function($orderDateItemLink) {
            return $orderDateItemLink->amount;
        });

        $query = ['key' => 'order_amount_total', 'value' => $total];
        $this->insertOrUpdate($query);
    }

    public function userCount()
    {
        $total = User::count();
        $query = ['key' => 'users', 'value' => $total];
        $this->insertOrUpdate($query);
    }

    public function producerCount()
    {
        $total = Producer::count();
        $query = ['key' => 'producers', 'value' => $total];
        $this->insertOrUpdate($query);
    }

    public function nodeCount()
    {
        $total = Node::count();
        $query = ['key' => 'nodes', 'value' => $total];
        $this->insertOrUpdate($query);
    }

    private function insertOrUpdate($query)
    {
        try {
            DB::table('statistics')->insert($query);
        } catch (\Exception $e) {
            DB::table('statistics')->where('key', $query['key'])->update(['value' => $query['value']]);
        }
    }
}