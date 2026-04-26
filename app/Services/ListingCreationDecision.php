<?php

namespace App\Services;

class ListingCreationDecision
{
    public function __construct(
        public readonly bool $allowed,
        public readonly string $message,
        public readonly ?int $remainingSlots = null,
        public readonly ?int $listingLimit = null,
        public readonly bool $usingFreeSlot = false,
    ) {
    }

    public function toArray(): array
    {
        return [
            'allowed' => $this->allowed,
            'message' => $this->message,
            'remaining_slots' => $this->remainingSlots,
            'listing_limit' => $this->listingLimit,
            'using_free_slot' => $this->usingFreeSlot,
        ];
    }
}
