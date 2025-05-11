<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class LicenseTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'locale_id', 'license_id',
    ];

    protected $casts = [

    ];

    public function locale()
    {
        return $this->belongsTo(Locale::class);
    }

    public function license()
    {
        return $this->belongsTo(License::class);
    }
}
