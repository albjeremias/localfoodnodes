<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToNodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nodes', function(Blueprint $table) {
            $table->boolean('is_farm')->nullable()->after('is_hidden');
            $table->boolean('is_adhoc')->nullable()->after('is_hidden');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nodes', function(Blueprint $table) {
            $table->dropColumn('is_farm');
            $table->dropColumn('is_adhoc');
        });
    }
}
