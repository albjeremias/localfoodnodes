<?php

namespace App\User;

use App\BaseModel;

class UserMembershipSubscription extends BaseModel
{
    public $timestamps = false;

    /**
     * Validation rules.
     *
     * @var array
     */
    protected $validationRules = [
        'user_id' => 'required',
        'customer_id' => 'required',
        'product_id' => 'required',
        'plan_id' => 'required',
        'subscription_id' => 'required',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'customer_id',
        'product_id',
        'plan_id',
        'subscription_id',
    ];
}
