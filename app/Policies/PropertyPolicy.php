<?php

namespace App\Policies;

use App\Models\Property;
use App\Models\User;
use App\Services\AgentListingQuotaService;

class PropertyPolicy
{
    public function create(User $user, string $listingType = 'sale'): bool
    {
        return app(AgentListingQuotaService::class)->canCreate($user, $listingType);
    }

    public function update(User $user, Property $property): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $user->agent && $property->agent_id === $user->agent->id;
    }

    public function delete(User $user, Property $property): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $this->update($user, $property);
    }

    public function approve(User $user): bool
    {
        return $user->isAdmin();
    }
}
