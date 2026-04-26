<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->foreignId('agent_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('email');
            $table->string('phone', 20)->nullable();
            $table->text('message');
            $table->enum('preferred_contact', ['email', 'phone', 'whatsapp'])->default('email');
            $table->enum('status', ['new', 'contacted', 'closed'])->default('new');
            $table->text('admin_notes')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();
            
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};