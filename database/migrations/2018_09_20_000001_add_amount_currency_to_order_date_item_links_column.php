<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAmountCurrencyToOrderDateItemLinksColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_date_item_links', function(Blueprint $table) {
            $table->float('amount')->after('quantity')->nullable();
            $table->string('currency')->after('amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_date_item_links', function(Blueprint $table) {
            $table->dropColumn('amount');
            $table->dropColumn('currency');
        });
    }
}
