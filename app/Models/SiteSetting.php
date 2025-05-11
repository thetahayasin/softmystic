<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
                    'home_meta_title', 'home_meta_description', 'category_meta_title', 'category_meta_description', 'search_meta_title', 'search_meta_description', 'download_meta_title', 'download_meta_description', 'single_meta_title', 'single_meta_description', 'default_locale', 'default_platform', 'site_logo', 'header_code', 'footer_code', 'home_page_ad', 'home_page_ad_2', 'results_page_ad', 'results_page_ad_2', 'single_page_ad', 'single_page_ad_2', 'download_page_ad', 'download_page_ad_2',
    ];

    protected $casts = [

    ];
}
