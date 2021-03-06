<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVatIdentificationNumberColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('producers', function (Blueprint $table) {
            $table->string('vat_identification_number')->after('city')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('producers', function (Blueprint $table) {
            $table->dropColumn('vat_identification_number');
        });
    }
}
