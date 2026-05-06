<?php

namespace Database\Seeders;

use App\Models\Agent;
use App\Models\AgentVerification;
use App\Models\Plan;
use App\Models\Profile;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoAccountsSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'user@realestate.ng'],
            [
                'name' => 'Demo Buyer',
                'password' => Hash::make('User@12345'),
                'role' => 'user',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        Profile::updateOrCreate(
            ['user_id' => $user->id],
            ['phone' => '+2348011111111']
        );

        $freeAgentUser = User::updateOrCreate(
            ['email' => 'freeagent@realestate.ng'],
            [
                'name' => 'Lagos Free Agent',
                'password' => Hash::make('Agent@12345'),
                'role' => 'agent',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        Profile::updateOrCreate(
            ['user_id' => $freeAgentUser->id],
            ['phone' => '+2348022222222', 'whatsapp_number' => '+2348022222222']
        );

        $freeAgent = Agent::updateOrCreate(
            ['user_id' => $freeAgentUser->id],
            [
                'company_name' => 'Mainland Realty Services',
                'verification_status' => 'verified',
                'verified_at' => now(),
            ]
        );

        AgentVerification::updateOrCreate(
            ['agent_id' => $freeAgent->id, 'status' => 'approved'],
            [
                'id_front_image' => 'verifications/free-agent-id-front.jpg',
                'selfie_image' => 'verifications/free-agent-selfie.jpg',
                'status' => 'approved',
                'reviewed_at' => now(),
            ]
        );

        $proAgentUser = User::updateOrCreate(
            ['email' => 'proagent@realestate.ng'],
            [
                'name' => 'Abuja Pro Agent',
                'password' => Hash::make('Agent@12345'),
                'role' => 'agent',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        Profile::updateOrCreate(
            ['user_id' => $proAgentUser->id],
            ['phone' => '+2348033333333', 'whatsapp_number' => '+2348033333333']
        );

        $proAgent = Agent::updateOrCreate(
            ['user_id' => $proAgentUser->id],
            [
                'company_name' => 'Prime Homes Nigeria Ltd',
                'verification_status' => 'verified',
                'verified_at' => now(),
            ]
        );

        AgentVerification::updateOrCreate(
            ['agent_id' => $proAgent->id, 'status' => 'approved'],
            [
                'id_front_image' => 'verifications/pro-agent-id-front.jpg',
                'selfie_image' => 'verifications/pro-agent-selfie.jpg',
                'status' => 'approved',
                'reviewed_at' => now(),
            ]
        );

        $plan = Plan::where('slug', 'professional')->first();

        if ($plan) {
            $durationDays = max(1, (int) $plan->duration_days);

            Subscription::updateOrCreate(
                [
                    'agent_id' => $proAgent->id,
                    'plan_id' => $plan->id,
                    'status' => 'active',
                ],
                [
                    'interval' => 'monthly',
                    'amount' => $plan->price_monthly,
                    'listing_limit' => $plan->listing_limit,
                    'used_listings' => 0,
                    'starts_at' => now()->toDateString(),
                    'ends_at' => now()->addDays($durationDays)->toDateString(),
                    'stripe_status' => 'active',
                ]
            );
        }
    }
}
