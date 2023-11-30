<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EndpointField extends Model
{
    use HasFactory;


    protected $fillable = ['endpoint_id', 'field_attributes'];

    protected $casts = [
        'field_attributes' => 'json',
    ];

    public function endpoint()
    {
        return $this->belongsTo(Endpoint::class);
    }
}
