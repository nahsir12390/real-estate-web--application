<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('short_description', 500)->nullable();
            $table->enum('property_type', ['house', 'apartment', 'land']);
            $table->enum('listing_type', ['rent', 'sale']);
            $table->decimal('price', 15, 2);
            $table->string('price_unit', 20)->nullable();
            $table->decimal('area', 10, 2)->nullable();
            $table->string('area_unit', 20)->nullable();
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->integer('garages')->nullable();
            $table->year('year_built')->nullable();
            $table->string('address');
            $table->string('city', 100);
            $table->string('state', 100);
            $table->string('zip_code', 20)->nullable();
            $table->string('country', 100)->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->json('amenities')->nullable();
            $table->enum('status', ['draft', 'pending', 'approved', 'rejected', 'sold', 'rented'])->default('draft');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_premium')->default(false);
            $table->integer('views')->default(0);
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            
            $table->index(['property_type', 'listing_type']);
            $table->index(['city', 'state']);
            $table->index('price');
            $table->index('status');
            $table->fullText(['title', 'description', 'address']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};