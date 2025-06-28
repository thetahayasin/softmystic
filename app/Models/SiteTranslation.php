<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SiteTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'home_meta_title', 'home_meta_description', 'category_meta_title', 'category_meta_description', 'search_meta_title', 'search_meta_description', 'download_meta_title', 'download_meta_description', 'single_meta_title', 'single_meta_description', 'search_results', 'category', 'download_button', 'footer_text', 'latest', 'popular', 'related', 'download', 'for', 'free', 'version', 'locale_id', 'hero_title', 'hero_text', 'featured_apps', 'latest_updates', 'new_releases', 'trending_apps', 'buy_now', 'nothing_found', 'downloading_text', 'author', 'license', 'requirements', 'size'
    ];

    protected $casts = [

    ];

    public function locale()
    {
        return $this->belongsTo(Locale::class);
    }
}
