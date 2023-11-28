<?php

// app/Rules/ValidFieldValueTypeRule.php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\EndpointField;

class ValidFieldValueTypeRule implements Rule
{
    protected $fieldId;

    public function __construct($fieldId)
    {
        $this->fieldId = $fieldId;
    }

    public function passes($attribute, $value)
    {
        $field = EndpointField::find($this->fieldId);

        if (!$field) {
            return false;
        }

        // Validate the value type based on the field's type
        $fieldType = $field->field_attributes['type'];

        // Implement your validation logic here based on the $fieldType
        switch ($fieldType) {
            case 'Int':
                return is_numeric($value) && is_int($value + 0);
            case 'String':
                return is_string($value);
            case 'Boolean':
                return is_bool($value) || $value === 'true' || $value === 'false';
            case 'Float':
                return is_numeric($value) && is_float($value + 0);
            // Add more cases for other types as needed
            default:
                // Default to true if the type is not recognized
                return true;
        }
    }

    public function message()
    {
        return 'The field value does not match the specified type.';
    }
}
