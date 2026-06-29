<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;

class PhoneNumber implements Rule
{

    public function passes($attribute, $value)
    {
        return preg_match("/^[0][0-9]{10}$/", $value);
    }


    public function message(): \Illuminate\Foundation\Application|array|string|\Illuminate\Contracts\Translation\Translator|null
    {
        return ":attribute وارد شده معتبر نیست.";
    }
}
