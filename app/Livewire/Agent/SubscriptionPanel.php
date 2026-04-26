<?php

namespace App\Livewire\Agent;

use App\Models\Plan;
use App\Models\Subscription;
use App\Services\AgentListingQuotaService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SubscriptionPanel extends Component
{
    public function render()
    {
        $agent = auth()->user()->agent;

        $activeSubscription = $agent?->activeSubscription()->with('plan')->first();
        $pendingSubscription = Subscription::query()
            ->where('agent_id', $agent?->id)
            ->where('status', Subscription::STATUS_PENDING)
            ->with('plan:id,name')
            ->latest()
            ->first();
        $history = Subscription::query()
            ->where('agent_id', $agent?->id)
            ->with('plan:id,name')
            ->latest()
            ->take(10)
            ->get();

        $quota = app(AgentListingQuotaService::class)->quotaSummary(auth()->user());
        $availablePlans = Plan::query()
            ->active()
            ->orderBy('price_monthly')
            ->get();

        $needsSubscription = ! (bool) ($quota['has_subscription'] ?? false);

        return view('livewire.agent.subscription-panel', compact('activeSubscription', 'pendingSubscription', 'history', 'quota', 'availablePlans', 'needsSubscription'));
    }

    public function subscribe($planId, $billingCycle = 'monthly'): void
    {
        $agent = auth()->user()->agent;

        if (! $agent) {
            $this->dispatch('notify', type: 'error', message: 'Agent profile not found.');
            return;
        }

        if (! in_array($billingCycle, ['monthly', 'yearly'], true)) {
            $this->dispatch('notify', type: 'error', message: 'Invalid billing cycle selected.');
            return;
        }

        $plan = Plan::query()->active()->findOrFail($planId);

        if ($billingCycle === 'yearly' && ! $plan->price_yearly) {
            $this->dispatch('notify', type: 'error', message: 'Yearly billing is not available for this plan.');
            return;
        }

        $price = $billingCycle === 'yearly' ? $plan->price_yearly : $plan->price_monthly;

        $startsAt = now();
        $durationDays = (int) $plan->duration_days;
        $endsAt = now()->addDays($durationDays);

        DB::transaction(function () use ($agent, $plan, $startsAt, $endsAt, $billingCycle, $price): void {
            Subscription::query()
                ->where('agent_id', $agent->id)
                ->whereIn('status', [Subscription::STATUS_ACTIVE, Subscription::STATUS_PENDING])
                ->update([
                    'status' => Subscription::STATUS_CANCELED,
                    'canceled_at' => now(),
                ]);

            Subscription::create([
                'agent_id' => $agent->id,
                'plan_id' => $plan->id,
                'starts_at' => $startsAt,
                'ends_at' => $endsAt,
                'interval' => $billingCycle,
                'amount' => $price,
                'listing_limit' => $plan->listing_limit,
                'used_listings' => 0,
                'status' => Subscription::STATUS_PENDING,
            ]);
        });

        $this->dispatch('notify', type: 'success', message: "Subscription request for {$plan->name} submitted. Awaiting activation.");
        $this->dispatch('$refresh');
    }
}
