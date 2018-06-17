<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('context_id')->required();
            $table->string('context')->required();
            $table->string('unique')->required();
            $table->string('title')->required();
            $table->string('message')->required();
            $table->string('variables')->nullable();
            $table->timestamps();
            $table->dateTime('sent_at')->nullable();
            $table->unique(['context_id', 'context', 'unique']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('notification_events');
    }
}
