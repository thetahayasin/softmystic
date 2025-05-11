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
        Schema::create('software_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tagline');
            $table->string('content');
            $table->string('change_log');
            $table->foreignId('software_id')->constrained()->onDelete('restrict');
            $table->foreignId('locale_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('software_translations');
    }
};
