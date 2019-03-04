<?php

namespace App\AdHoc;

class AdHocLocation extends BaseModel
{
    /**
     * Validation rules.
     *
     * @var array
     */
    protected $validationRules = [
        'name' => 'required',
        'address' => 'required',
        'zip' => 'required',
        'city' => 'required',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
        'zip',
        'city',
    ];
}
