<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActiveStockPriceDeadlineToDeliveryDates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_node_delivery_links', function(Blueprint $table) {
            $table->boolean('active')->nullable();
            $table->integer('quantity')->nullable();
            $table->float('price')->nullable();
            $table->integer('deadline')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_node_delivery_links', function(Blueprint $table) {
            $table->dropColumn('active');
            $table->dropColumn('quantity');
            $table->dropColumn('price');
            $table->dropColumn('deadline');
        });
    }
}
