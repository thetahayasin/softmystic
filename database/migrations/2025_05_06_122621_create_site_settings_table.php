<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('default_locale');
            $table->string('default_platform');
            $table->string('site_logo');
            $table->string('home_meta_title');
            $table->string('home_meta_description');
            $table->string('category_meta_title');
            $table->string('category_meta_description');
            $table->string('search_meta_title');
            $table->string('search_meta_description');
            $table->string('download_meta_title');
            $table->string('download_meta_description');
            $table->string('single_meta_title');
            $table->string('single_meta_description');
            $table->string('header_code');
            $table->string('footer_code');
            $table->string('home_page_ad');
            $table->string('home_page_ad_2');
            $table->string('results_page_ad');
            $table->string('results_page_ad_2');
            $table->string('single_page_ad');
            $table->string('single_page_ad_2');
            $table->string('download_page_ad');
            $table->string('download_page_ad_2');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
