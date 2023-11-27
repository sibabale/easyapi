<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\EndpointField;

class UniqueFieldNameUpdateRule implements Rule
{
    protected $endpointId;
    protected $fieldId;

    public function __construct($endpointId, $fieldId)
    {
        $this->endpointId = $endpointId;
        $this->fieldId = $fieldId;
    }

    public function passes($attribute, $value)
    {
        // If $value is a string, decode it; otherwise, consider it as already decoded
        $decodedValue = is_string($value) ? json_decode($value, true) : $value;

        // Check if $decodedValue is an array or an object
        $fields = is_array($decodedValue) ? $decodedValue : [$decodedValue];

        // Check if the 'name' property is unique within the endpoint excluding the current field
        foreach ($fields as $field) {
            $fieldName = is_array($field) ? $field['name'] : $field;

            $existingField = EndpointField::where('endpoint_id', $this->endpointId)
                ->whereJsonContains('field_attributes->name', $fieldName)
                ->where('id', '!=', $this->fieldId)
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
