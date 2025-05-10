<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SoftwareTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'tagline', 'content', 'change_log', 'software_id', 'locale_id',
    ];

    protected $casts = [

    ];

    public function software()
    {
        return $this->belongsTo(Software::class);
    }

    public function locale()
    {
        return $this->belongsTo(Locale::class); // Relationship to the 'Locale' model
    }
    
}
