<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
    ];

    protected $casts = [

    ];

    public function licenseTranslations()
    {
        return $this->hasMany(LicenseTranslation::class);
    }

    public function softwares()
    {
        return $this->hasMany(Software::class);
    }
}
