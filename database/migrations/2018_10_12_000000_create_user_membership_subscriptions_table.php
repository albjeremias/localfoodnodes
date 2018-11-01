<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMembershipSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_membership_subscriptions', function (Blueprint $table) {
            $table->integer('user_id')->required();
            $table->string('customer_id')->required();
            $table->string('product_id')->required();
            $table->string('plan_id')->required();
            $table->string('subscription_id')->required();
            $table->unique(['user_id', 'customer_id', 'product_id', 'plan_id', 'subscription_id'], 'user_cust_prod_plan_sub_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_membership_subscriptions');
    }
}
