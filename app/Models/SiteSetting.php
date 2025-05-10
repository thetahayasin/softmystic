<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'default_locale', 'default_platform', 'site_logo', 'header_code', 'footer_code', 'home_page_ad', 'home_page_ad_2', 'results_page_ad', 'results_page_ad_2', 'single_page_ad', 'single_page_ad_2', 'download_page_ad', 'download_page_ad_2',
    ];

    protected $casts = [

    ];
}
