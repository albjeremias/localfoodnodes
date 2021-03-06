<?php

namespace App;

class Notification extends BaseModel
{
    /**
     * Validation rules.
     *
     * @var array
     */
    protected $validationRules = [
        'user_id' => 'required',
        'title' => 'required',
        'message' => 'required',
        'variables' => '',
        'viewed_at' => '',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'variables',
        'viewed_at',
    ];

    /**
     * Attribute casting.
     *
     * @var array
     */
    protected $casts = [
        'variables' => 'array',
    ];
}
