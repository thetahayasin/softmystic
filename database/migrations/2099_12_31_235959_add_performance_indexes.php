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
        // Software table indexes
        Schema::table('software', function (Blueprint $table) {
            $table->index(['platform_id', 'category_id'], 'idx_software_platform_category');
            $table->index(['platform_id', 'is_featured'], 'idx_software_platform_featured');
            $table->index(['platform_id', 'is_sponsored'], 'idx_software_platform_sponsored');
            $table->index(['platform_id', 'downloads'], 'idx_software_platform_downloads');
            $table->index(['slug', 'platform_id'], 'idx_software_slug_platform');
            $table->index(['platform_id', 'updated_at'], 'idx_software_platform_updated');
            $table->index(['platform_id', 'created_at'], 'idx_software_platform_created');
        });

        // Software translations table indexes
        Schema::table('software_translations', function (Blueprint $table) {
            $table->index(['software_id', 'locale_id'], 'idx_software_translations_software_locale');
            $table->index('locale_id', 'idx_software_translations_locale');
        });

        // Category translations table indexes
        Schema::table('category_translations', function (Blueprint $table) {
            $table->index(['category_id', 'locale_id'], 'idx_category_translations_category_locale');
        });

        // License translations table indexes
        Schema::table('license_translations', function (Blueprint $table) {
            $table->index(['license_id', 'locale_id'], 'idx_license_translations_license_locale');
        });

        // Locale table indexes
        Schema::table('locales', function (Blueprint $table) {
            $table->index('slug', 'idx_locales_slug');
            $table->index('key', 'idx_locales_key');
        });

        // Platform table indexes
        Schema::table('platforms', function (Blueprint $table) {
            $table->index('slug', 'idx_platforms_slug');
        });

        // Category table indexes
        Schema::table('categories', function (Blueprint $table) {
            $table->index('slug', 'idx_categories_slug');
        });

        // Site translations table indexes
        Schema::table('site_translations', function (Blueprint $table) {
            $table->index('locale_id', 'idx_site_translations_locale');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('software', function (Blueprint $table) {
            $table->dropIndex('idx_software_platform_category');
            $table->dropIndex('idx_software_platform_featured');
            $table->dropIndex('idx_software_platform_sponsored');
            $table->dropIndex('idx_software_platform_downloads');
            $table->dropIndex('idx_software_slug_platform');
            $table->dropIndex('idx_software_platform_updated');
            $table->dropIndex('idx_software_platform_created');
        });

        Schema::table('software_translations', function (Blueprint $table) {
            $table->dropIndex('idx_software_translations_software_locale');
            $table->dropIndex('idx_software_translations_locale');
        });

        Schema::table('category_translations', function (Blueprint $table) {
            $table->dropIndex('idx_category_translations_category_locale');
        });

        Schema::table('license_translations', function (Blueprint $table) {
            $table->dropIndex('idx_license_translations_license_locale');
        });

        Schema::table('locales', function (Blueprint $table) {
            $table->dropIndex('idx_locales_slug');
            $table->dropIndex('idx_locales_key');
        });

        Schema::table('platforms', function (Blueprint $table) {
            $table->dropIndex('idx_platforms_slug');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex('idx_categories_slug');
        });

        Schema::table('site_translations', function (Blueprint $table) {
            $table->dropIndex('idx_site_translations_locale');
        });
    }
}; 