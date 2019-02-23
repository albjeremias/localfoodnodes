<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToDeliveryDates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_node_delivery_links', function(Blueprint $table) {
            $table->integer('product_variant_id')->nullable()->after('product_id');
            $table->integer('quantity')->nullable();
            $table->float('price')->nullable();
            $table->integer('deadline')->nullable();

            $table->dropIndex('product_id_node_id_date');
            $table->unique(['product_id', 'product_variant_id', 'node_id', 'date'], 'product_variant_node_date');
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
            $table->dropColumn('product_variant_id');
            $table->dropColumn('quantity');
            $table->dropColumn('price');
            $table->dropColumn('deadline');
        });
    }
}
