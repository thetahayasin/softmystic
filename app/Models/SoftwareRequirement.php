<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SoftwareRequirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'software_id', 'requirement_id',
    ];

    protected $casts = [

    ];

    public function software(): HasMany
    {
        return $this->hasMany(Software::class);
    }

    public function requirements(): HasMany
    {
        return $this->hasMany(Requirement::class);
    }
}
