<?php

namespace App;

class NotificationEvent extends BaseModel
{
    /**
     * Validation rules.
     *
     * @var array
     */
    protected $validationRules = [
        'context' => 'required',
        'context_id' => 'required',
        'unique' => 'required',
        'title' => 'required',
        'message' => 'required',
        'variables' => '',
        'sent_at' => '',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'context',
        'context_id',
        'unique',
        'title',
        'message',
        'variables',
        'sent_at',
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
