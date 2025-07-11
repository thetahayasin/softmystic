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
        Schema::create('software', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->bigInteger('file_size')->nullable();
            $table->string('version');
            $table->foreignId('author_id');
            $table->string('logo');
            $table->text('download_url');
            $table->string('buy_url')->nullable();
            $table->bigInteger('downloads')->default(0);
            $table->foreignId('category_id')->constrained()->onDelete('restrict');
            $table->foreignId('user_id')->constrained()->onDelete('restrict');
            $table->foreignId('license_id')->constrained()->onDelete('restrict');
            $table->foreignId('platform_id')->constrained()->onDelete('restrict');
            $table->boolean('is_sponsored')->default('0');
            $table->boolean('is_featured')->default('0');
            $table->unsignedInteger('total_ratings')->default(0);
            $table->decimal('average_rating', 4, 2)->default(0.00); // store as 1–10 scale
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('software');
    }
};
