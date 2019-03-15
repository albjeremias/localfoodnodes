<?php

namespace App\Node;

use Illuminate\Database\Eloquent\SoftDeletes;

class NodeDate extends \App\BaseModel
{
    use SoftDeletes;

    public $timestamps = false;

    /**
     * Validation rules.
     *
     * @var array
     */
    protected $validationRules = [
        'node_id' => 'required',
        'datetime' => 'datetime|required',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'node_id',
        'datetime'
    ];
}
