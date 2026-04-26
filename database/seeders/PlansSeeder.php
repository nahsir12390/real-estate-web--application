<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlansSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Starter',
                'slug' => 'starter',
                'description' => 'Good for new Nigerian agents posting a few listings each month.',
                'price_monthly' => 15000.00,
                'price_yearly' => 150000.00,
                'listing_limit' => 10,
                'duration_days' => 30,
                'features' => ['10 active listings', 'Basic support'],
                'is_popular' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Professional',
                'slug' => 'professional',
                'description' => 'For active agencies across Lagos, Abuja, and other major cities.',
                'price_monthly' => 45000.00,
                'price_yearly' => 450000.00,
                'listing_limit' => 50,
                'duration_days' => 30,
                'features' => ['50 active listings', 'Priority support', 'Featured listings'],
                'is_popular' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'description' => 'For large Nigerian brokers with high listing volume.',
                'price_monthly' => 120000.00,
                'price_yearly' => 1200000.00,
                'listing_limit' => 200,
                'duration_days' => 30,
                'features' => ['200 active listings', 'Dedicated support', 'Premium badge'],
                'is_popular' => false,
                'is_active' => true,
            ],
        ];

        foreach ($plans as $plan) {
            Plan::updateOrCreate(
                ['slug' => $plan['slug']],
                $plan
            );
        }
    }
}
