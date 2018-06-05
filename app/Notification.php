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
        'notification_creator_id' => 'required',
        'notification_creator_type' => 'required',
        'notification_entity_id' => 'required',
        'notification_entity_type' => 'required',
        'title' => 'required',
        'message' => 'required',
        'message_variables' => '',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'notification_creator_id',
        'notification_creator_type',
        'notification_entity_id',
        'notification_entity_type',
        'title',
        'message',
        'message_variables',
    ];

    /**
     * Attribute casting.
     *
     * @var array
     */
    protected $casts = [
        'message_variables' => 'array',
    ];
}
