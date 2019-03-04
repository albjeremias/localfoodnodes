<?php

namespace App\AdHoc;

class AdHocDate extends BaseModel
{
    /**
     * Validation rules.
     *
     * @var array
     */
    protected $validationRules = [
        'entity_id' => 'required',
        'entity_type' => 'required',
        'date' => 'required',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'entity_id',
        'entity_type',
        'date',
    ];
}
