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
            $table->foreignId('locale_id')->constrained()->onDelete('restrict');
            $table->foreignId('platform_id')->constrained()->onDelete('restrict');
            $table->string('site_logo')->nullable();
            $table->text('header_code')->nullable();
            $table->text('footer_code')->nullable();
            $table->text('home_page_ad')->nullable();
            $table->text('home_page_ad_2')->nullable();
            $table->text('results_page_ad')->nullable();
            $table->text('results_page_ad_2')->nullable();
            $table->text('single_page_ad')->nullable();
            $table->text('single_page_ad_2')->nullable();
            $table->text('download_page_ad')->nullable();
            $table->text('download_page_ad_2')->nullable();
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
