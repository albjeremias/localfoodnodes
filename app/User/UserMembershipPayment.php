<?php

namespace App\User;

use App\BaseModel;

class UserMembershipPayment extends BaseModel
{
    /**
     * Validation rules.
     *
     * @var array
     */
    protected $validationRules = [
        'user_id' => 'required',
        'amount' => 'required',
        'currency' => 'required',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'amount',
        'currency',
    ];

    /**
     * Get date one year forward from payment date.
     *
     * @return Date
     */
    public function getDateOneYearForward()
    {
        $date = new \DateTime($this->created_at);
        return $date->modify('+1 year');
    }

    /**
     * Get days until membership expires.
     *
     * @return int
     */
    public function expiresInDays()
    {
        $current = new \DateTime(date('Y-m-d'));

        return $this->getDateOneYearForward()->diff($current)->days;
    }

    /**
     * Get amount.
     *
     * @param int $value
     * @param boolean $raw
     * @return int
     */
    public function getAmountAttribute($value, $raw = false)
    {
        if ($raw) {
            return $value;
        } else {
            if (!in_array($this->currency, config('app.zero_decimal_currencies'))) {
                return $value / 100;
            }

            return (int) $value;
        }
    }
}
