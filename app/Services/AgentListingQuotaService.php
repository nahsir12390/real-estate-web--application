<?php

namespace App\Services;

use App\Models\Property;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;

class AgentListingQuotaService
{
    public function evaluate(User $user, string $listingType = 'sale'): ListingCreationDecision
    {
        if (! $user->isAgent()) {
            return new ListingCreationDecision(false, 'Only agents can create properties.');
        }

        $agent = $user->agent;

        if (! $agent) {
            return new ListingCreationDecision(false, 'Agent profile not found.');
        }

        if (! $agent->isVerified()) {
            return new ListingCreationDecision(false, 'Your agent account must be verified before posting properties.');
        }

        $listingType = strtolower($listingType);

        if (! in_array($listingType, ['sale', 'rent'], true)) {
            return new ListingCreationDecision(false, 'Invalid listing type.');
        }

        $activeSubscription = $agent->activeSubscription()->first();

        if ($activeSubscription instanceof Subscription) {
            $activeListings = $this->countActiveListings($agent->id);
            $remainingSlots = max(0, $activeSubscription->listing_limit - $activeListings);

            if ($remainingSlots <= 0) {
                return new ListingCreationDecision(
                    false,
                    'You have reached your plan listing limit. Upgrade your plan or remove an active listing.',
                    0,
                    $activeSubscription->listing_limit,
                );
            }

            return new ListingCreationDecision(
                true,
                'Listing allowed under your active subscription.',
                $remainingSlots,
                $activeSubscription->listing_limit,
            );
        }

        // Free starter allowance: one in-quota "for sale" listing for verified agents.
        if ($listingType === 'sale') {
            $activeSaleListings = $this->countSaleListingsInQuota($agent->id);

            if ($activeSaleListings < 1) {
                return new ListingCreationDecision(
                    true,
                    'You can publish your first sale listing on the free starter allowance.',
                    1 - $activeSaleListings,
                    1,
                    true,
                );
            }
        }

        if ($listingType === 'rent') {
            return new ListingCreationDecision(
                false,
                'Free allowance applies to one sale listing only. Switch to "For Sale" or subscribe to list rentals.',
            );
        }

        return new ListingCreationDecision(
            false,
            'Your free listing has been used. Subscribe to a plan to post more properties.',
        );
    }

    public function canCreate(User $user, string $listingType = 'sale'): bool
    {
        return $this->evaluate($user, $listingType)->allowed;
    }

    /**
     * Livewire-friendly method: call before create() and catch in component if needed.
     */
    public function authorizeOrFail(User $user, string $listingType = 'sale'): ListingCreationDecision
    {
        $decision = $this->evaluate($user, $listingType);

        if (! $decision->allowed) {
            throw new AuthorizationException($decision->message);
        }

        return $decision;
    }

    public function quotaSummary(User $user): array
    {
        $agent = $user->agent;

        if (! $agent) {
            return [
                'has_subscription' => false,
                'listing_limit' => 0,
                'active_listings' => 0,
                'remaining_slots' => 0,
                'free_sale_slot_available' => false,
            ];
        }

        $activeListings = $this->countActiveListings($agent->id);
        $activeSaleListings = $this->countSaleListingsInQuota($agent->id);
        $subscription = $agent->activeSubscription()->first();

        if ($subscription instanceof Subscription) {
            $limit = $subscription->listing_limit;

            return [
                'has_subscription' => true,
                'listing_limit' => $limit,
                'active_listings' => $activeListings,
                'remaining_slots' => max(0, $limit - $activeListings),
                'free_sale_slot_available' => false,
            ];
        }

        return [
            'has_subscription' => false,
            'listing_limit' => 1,
            'active_listings' => $activeSaleListings,
            'remaining_slots' => max(0, 1 - $activeSaleListings),
            'free_sale_slot_available' => $activeSaleListings < 1,
        ];
    }

    private function countActiveListings(int $agentId, ?string $listingType = null): int
    {
        return Property::query()
            ->where('agent_id', $agentId)
            ->when($listingType, fn ($query) => $query->where('listing_type', $listingType))
            ->countedInQuota()
            ->count();
    }

    private function countSaleListingsInQuota(int $agentId): int
    {
        return Property::query()
            ->where('agent_id', $agentId)
            ->where('listing_type', Property::LISTING_SALE)
            ->countedInQuota()
            ->count();
    }
}
