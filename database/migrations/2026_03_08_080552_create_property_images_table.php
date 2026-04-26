<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->string('image_path');
            $table->string('thumbnail_path')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->string('alt_text')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
            
            $table->index(['property_id', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_images');
    }
};