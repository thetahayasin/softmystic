<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locale extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'key', 'slug'
    ];

    protected $casts = [

    ];

    public function softwareTranslations()
    {
        return $this->hasMany(SoftwareTranslation::class);
    }
}
