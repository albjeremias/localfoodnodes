<?php

namespace App\System\Parsers\TransactionParser;

class Transaction extends \App\BaseModel
{
    protected $table = 'economy_transactions';

    public $timestamps = false;

    /**
     * Validation rules.
     *
     * @var array
     */
    public $validationRules = [
        'hash' => 'required|unique:economy_transactions',
        'date' => 'required|date',
        'ref' => 'required',
        'description' => 'required',
        'amount' => 'required',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hash',
        'date',
        'ref',
        'description',
        'amount',
        'category',
    ];

    /**
     * Get transaction year for filters
     *
     * @param string $value A DateTime string
     * @return void
     */
    public function getYearAttribute()
    {
        $dateTime = new \DateTime($this->date);

        return $dateTime->format('Y');
    }
}
