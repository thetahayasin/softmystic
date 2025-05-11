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
        Schema::create('site_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('home_meta_title')->nullable();
            $table->string('home_meta_description')->nullable();
            $table->string('category_meta_title')->nullable();
            $table->string('category_meta_description')->nullable();
            $table->string('search_meta_title')->nullable();
            $table->string('search_meta_description')->nullable();
            $table->string('download_meta_title')->nullable();
            $table->string('download_meta_description')->nullable();
            $table->string('single_meta_title')->nullable();
            $table->string('single_meta_description')->nullable();
            $table->string('search_results');
            $table->string('category');
            $table->string('download_button');
            $table->string('footer_text');
            $table->string('latest');
            $table->string('popular');
            $table->string('related');
            $table->string('download');
            $table->string('for');
            $table->string('free');
            $table->string('version');
            $table->foreignId('locale_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_translations');
    }
};
