<?php
// app/Rules/UniqueJsonNameRule.php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UniqueJsonNameRule implements Rule
{
    public function passes($attribute, $value)
    {
        // $value is already an array, no need to decode
        // Check if the 'name' property is unique
        return count(array_unique(array_column($value, 'name'))) === count($value);
    }

    public function message()
    {
        return 'Each field name must be unique within the JSON attributes.';
    }
}
