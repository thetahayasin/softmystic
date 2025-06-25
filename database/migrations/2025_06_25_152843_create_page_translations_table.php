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
        Schema::create('page_translations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content')->nullable();
            $table->foreignId('page_id')->constrained('pages')->onDelete('cascade');
            $table->foreignId('locale_id')->constrained('locales')->onDelete('cascade');
            $table->timestamps();

            // $table->unique(['page_id', 'locale_id']); // Ensures one translation per locale per page
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_translations');
    }
};
