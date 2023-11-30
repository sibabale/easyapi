<?php
// app/Rules/UniqueFieldNameRule.php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\EndpointField;

class UniqueFieldNameRule implements Rule
{
    protected $endpointId;

    public function __construct($endpointId)
    {
        $this->endpointId = $endpointId;
    }

    public function passes($attribute, $value)
    {
        // If $value is a string, decode it; otherwise, consider it as already decoded
        $decodedValue = is_string($value) ? json_decode($value, true) : $value;

        // Check if $decodedValue is not null before iterating
        if ($decodedValue === null) {
            return false;
        }

        // Check if $decodedValue is an array or an object before iterating
        $fields = is_array($decodedValue) ? $decodedValue : [$decodedValue];

        // Check if the 'name' property is unique within the endpoint
        foreach ($fields as $field) {
            $fieldName = is_array($field) ? $field['name'] : $field;

            $existingField = EndpointField::where('endpoint_id', $this->endpointId)
                ->whereJsonContains('field_attributes->name', $fieldName)
                ->first();

            if ($existingField) {
                return false;
            }
        }

        return true;
    }


    public function message()
    {
        return 'Each field name must be unique within the endpoint.';
    }
}
