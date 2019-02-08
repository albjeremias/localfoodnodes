<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function(Blueprint $table) {
            $table->boolean('has_stock')->before('created_at')->nullable();
            $table->string('stock_type')->before('created_at')->nullable();
            $table->integer('stock_quantity')->before('created_at')->nullable();
            $table->boolean('shared_variant_quantity')->before('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function(Blueprint $table) {
            $table->dropColumn('has_stock');
            $table->dropColumn('stock_type');
            $table->dropColumn('stock_quantity');
            $table->dropColumn('shared_variant_quantity');

        });
    }
}
