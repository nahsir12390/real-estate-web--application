<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->constrained()->onDelete('cascade');
            $table->foreignId('plan_id')->constrained()->onDelete('cascade');
            $table->string('stripe_subscription_id')->nullable();
            $table->string('stripe_customer_id')->nullable();
            $table->string('stripe_price_id')->nullable();
            $table->string('stripe_status', 50)->nullable();
            $table->enum('interval', ['monthly', 'yearly'])->default('monthly');
            $table->decimal('amount', 10, 2);
            $table->integer('listing_limit');
            $table->integer('used_listings')->default(0);
            $table->date('starts_at');
            $table->date('ends_at');
            $table->date('trial_ends_at')->nullable();
            $table->timestamp('canceled_at')->nullable();
            $table->enum('status', ['active', 'pending', 'canceled', 'expired'])->default('pending');
            $table->timestamps();
            
            $table->index(['status', 'ends_at']);
            $table->index('starts_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};