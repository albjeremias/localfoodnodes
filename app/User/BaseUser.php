<?php

namespace App\User;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class BaseUser extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * Proxy to BaseModel validate.
     */
    public function validate($data, $rules = [], $messages = [])
    {
        if (empty($rules)) {
            $rules = $this->validationRules;
        }

        if (isset($this->validationMessages)) {
            $messages = array_merge($this->validationMessages, $messages);
        }

        $baseModel = new \App\BaseModel();
        return $baseModel->validate($data, $rules, $messages);
    }

    /**
     * Proxy to BaseModel sanitize.
     */
    public function sanitize($data, $rules = [])
    {
        if (empty($rules)) {
            $rules = $this->validationRules;
        }

        $baseModel = new \App\BaseModel();
        return $baseModel->sanitize($data, $rules);
    }
}
