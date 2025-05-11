<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SiteTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'search_results', 'category', 'download_button', 'footer_text', 'latest', 'popular', 'related', 'download', 'for', 'free', 'version', 'locale_id',
    ];

    protected $casts = [

    ];

    public function locale(): HasOne
    {
        return $this->hasOne(Locale::class);
    }
}
