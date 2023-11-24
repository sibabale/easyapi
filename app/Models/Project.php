<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'api_version',
        'api_type',
        'database',
    ];

    // Define relationships if needed
    public function user()
    {
        return $this->belongsTo(
            ::class);
    }

    public function endpoints()
    {
        return $this->hasMany(Endpoint::class);
    }
}
