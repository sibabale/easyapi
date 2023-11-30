<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endpoint extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'project_id']; // Add other fillable attributes as needed

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function fields()
    {
        return $this->hasMany(EndpointField::class);
    }
}
