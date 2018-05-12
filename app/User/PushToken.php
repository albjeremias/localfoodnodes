<?php

namespace App\User;

class PushToken extends \App\BaseModel
{
    /**
     * Validation rules.
     *
     * @var array
     */
    protected $validationRules = [
        'user_id' => 'required',
        'token' => 'required',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'token',
    ];
}
