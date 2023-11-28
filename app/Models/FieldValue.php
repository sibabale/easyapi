<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldValue extends Model
{
    use HasFactory;

    protected $fillable = ['field_id', 'value'];

    public function endpointField()
    {
        return $this->belongsTo(EndpointField::class, 'field_id');
    }

    public static function castValue($value, $type)
    {
        switch ($type) {
            case 'int':
                return (int)$value;
            case 'float':
                return (float)$value;
            case 'boolean':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            case 'varchar(20)':
                return substr($value, 0, 20); // Adjust length as needed
            case 'varchar(255)':
                return substr($value, 0, 255); // Adjust length as needed
            case 'text':
                return $value;
            // Add other type cases as needed
            default:
                return $value;
        }
    }

}
