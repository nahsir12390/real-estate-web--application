<div class="space-y-6">
    <!-- Navigation Button -->
    <div class="flex justify-end">
        <a href="{{ route('agent.dashboard') }}"
           class="inline-flex items-center gap-2 rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-300 dark:hover:bg-zinc-800">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Dashboard
        </a>
    </div>

    <!-- No Subscription Warning -->
    @if($needsSubscription)
        <div class="rounded-xl border-l-4 border-yellow-500 bg-yellow-50 p-4 dark:border-yellow-600 dark:bg-yellow-900/20">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-600 dark:text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-300">No Active Subscription</h3>
                    <p class="mt-1 text-sm text-yellow-700 dark:text-yellow-400">
                        You are currently not subscribed to any plan. Submit a subscription request to continue posting beyond your free allowance.
                    </p>
                </div>
            </div>
        </div>
    @endif

    @if($pendingSubscription)
        <div class="rounded-xl border-l-4 border-blue-500 bg-blue-50 p-4 dark:border-blue-600 dark:bg-blue-900/20">
            <h3 class="text-sm font-medium text-blue-800 dark:text-blue-300">Subscription Pending Activation</h3>
            <p class="mt-1 text-sm text-blue-700 dark:text-blue-400">
                Your {{ $pendingSubscription->plan?->name }} request is pending admin activation.
            </p>
        </div>
    @endif

    <!-- Current Plan & Quota Summary -->
    <div class="grid gap-4 md:grid-cols-2">
        <!-- Current Plan Card -->
        <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Current Plan</h2>
                    @if($activeSubscription)
                        <p class="mt-2 text-2xl font-semibold text-zinc-900 dark:text-white">{{ $activeSubscription->plan?->name }}</p>
                        <div class="mt-2 flex items-center gap-2">
                            <span class="rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                {{ ucfirst($activeSubscription->status) }}
                            </span>
                            <span class="text-xs text-zinc-500 dark:text-zinc-400">
                                {{ $activeSubscription->starts_at->format('M d, Y') }} - {{ $activeSubscription->ends_at->format('M d, Y') }}
                            </span>
                        </div>
                    @else
                        <p class="mt-2 text-lg text-zinc-600 dark:text-zinc-400">No active subscription</p>
                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-500">You are on free tier</p>
                    @endif
                </div>
                @if($activeSubscription)
                    <div class="rounded-full bg-blue-100 p-2 dark:bg-blue-900/30">
                        <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                            <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quota Card -->
        <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            <h2 class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Listing Quota</h2>
            <div class="mt-4 space-y-4">
                <div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-zinc-600 dark:text-zinc-400">Used</span>
                        <span class="font-medium text-zinc-900 dark:text-white">
                            {{ ($quota['listing_limit'] ?? 0) - ($quota['remaining_slots'] ?? 0) }} / {{ $quota['listing_limit'] ?? 0 }}
                        </span>
                    </div>
                    @if(($quota['listing_limit'] ?? 0) > 0)
                        @php
                            $percentage = min(100, ((($quota['listing_limit'] ?? 0) - ($quota['remaining_slots'] ?? 0)) / ($quota['listing_limit'] ?? 1)) * 100);
                        @endphp
                        <div class="mt-2 h-2 w-full rounded-full bg-zinc-200 dark:bg-zinc-700">
                            <div class="h-2 rounded-full bg-blue-600 transition-all duration-300" style="width: {{ $percentage }}%"></div>
                        </div>
                    @endif
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800">
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Remaining Slots</p>
                        <p class="text-xl font-semibold text-zinc-900 dark:text-white">{{ $quota['remaining_slots'] ?? 0 }}</p>
                    </div>
                    @if(!($quota['has_subscription'] ?? false))
                        <div class="rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800">
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">Free Sale Slot</p>
                            <p class="text-xl font-semibold {{ ($quota['free_sale_slot_available'] ?? false) ? 'text-green-600' : 'text-red-600' }}">
                                {{ ($quota['free_sale_slot_available'] ?? false) ? 'Available' : 'Used' }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Available Plans -->
    <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Available Plans</h2>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Choose a plan that fits your needs</p>
            </div>
        </div>

        @if($availablePlans->isEmpty())
            <div class="rounded-lg bg-zinc-50 p-8 text-center dark:bg-zinc-800">
                <svg class="mx-auto h-12 w-12 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-zinc-900 dark:text-white">No Plans Available</h3>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">No active plans are available right now. Please contact admin.</p>
            </div>
        @else
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($availablePlans as $plan)
                    <div class="relative rounded-xl border {{ $plan->is_popular ? 'border-blue-500 shadow-lg dark:border-blue-400' : 'border-zinc-200 dark:border-zinc-700' }} bg-white p-6 transition hover:shadow-md dark:bg-zinc-800">
                        @if($plan->is_popular)
                            <div class="absolute -top-3 left-1/2 -translate-x-1/2">
                                <span class="rounded-full bg-blue-600 px-3 py-1 text-xs font-medium text-white">Most Popular</span>
                            </div>
                        @endif

                        <div class="text-center">
                            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">{{ $plan->name }}</h3>
                            @if($plan->description)
                                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ $plan->description }}</p>
                            @endif
                        </div>

                        <div class="mt-4 text-center">
                            <div class="flex items-center justify-center gap-1">
                                <span class="text-3xl font-bold text-zinc-900 dark:text-white">₦{{ number_format((float) $plan->price_monthly) }}</span>
                                <span class="text-sm text-zinc-500 dark:text-zinc-400">/mo</span>
                            </div>
                            @if($plan->price_yearly)
                                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                                    ₦{{ number_format((float) $plan->price_yearly) }}/year 
                                    <span class="text-green-600 dark:text-green-400">
                                        (Save {{ round((1 - $plan->price_yearly/($plan->price_monthly*12)) * 100) }}%)
                                    </span>
                                </p>
                            @endif
                        </div>

                        <div class="mt-6 space-y-3">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-zinc-600 dark:text-zinc-400">Listing Limit</span>
                                <span class="font-medium text-zinc-900 dark:text-white">{{ $plan->listing_limit }} properties</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-zinc-600 dark:text-zinc-400">Duration</span>
                                <span class="font-medium text-zinc-900 dark:text-white">{{ $plan->duration_days }} days</span>
                            </div>
                            @if(is_array($plan->features) && count($plan->features) > 0)
                                <div class="border-t border-zinc-200 pt-3 dark:border-zinc-700">
                                    <p class="mb-2 text-xs font-medium text-zinc-500 dark:text-zinc-400">Features</p>
                                    <ul class="space-y-1.5">
                                        @foreach($plan->features as $feature)
                                            <li class="flex items-start gap-2 text-xs">
                                                <svg class="mt-0.5 h-3 w-3 flex-shrink-0 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                </svg>
                                                <span class="text-zinc-600 dark:text-zinc-400">{{ $feature }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>

                        <div class="mt-6 space-y-2">
                            <button wire:click="subscribe({{ $plan->id }}, 'monthly')"
                                    wire:loading.attr="disabled"
                                    wire:target="subscribe({{ $plan->id }}, 'monthly')"
                                    class="w-full rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 dark:bg-blue-500 dark:hover:bg-blue-600">
                                <span wire:loading.remove wire:target="subscribe({{ $plan->id }}, 'monthly')">Request Monthly</span>
                                <span wire:loading wire:target="subscribe({{ $plan->id }}, 'monthly')" class="flex items-center justify-center gap-2">
                                    <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Processing...
                                </span>
                            </button>
                            
                            @if($plan->price_yearly)
                                <button wire:click="subscribe({{ $plan->id }}, 'yearly')"
                                        wire:loading.attr="disabled"
                                        wire:target="subscribe({{ $plan->id }}, 'yearly')"
                                        class="w-full rounded-lg border border-green-600 bg-white px-4 py-2 text-sm font-medium text-green-600 transition hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 disabled:opacity-50 dark:border-green-500 dark:bg-transparent dark:text-green-400 dark:hover:bg-green-900/20">
                                    <span wire:loading.remove wire:target="subscribe({{ $plan->id }}, 'yearly')">Request Yearly</span>
                                    <span wire:loading wire:target="subscribe({{ $plan->id }}, 'yearly')" class="flex items-center justify-center gap-2">
                                        <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Processing...
                                    </span>
                                </button>
                            @endif
                        </div>

                        @if($activeSubscription && $activeSubscription->plan_id === $plan->id)
                            <div class="absolute inset-0 flex items-center justify-center rounded-xl bg-blue-500/10 backdrop-blur-[1px]">
                                <span class="rounded-full bg-blue-600 px-3 py-1.5 text-xs font-medium text-white">Current Plan</span>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Subscription History -->
    <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Subscription History</h2>
        
        <div class="mt-4 space-y-3">
            @forelse($history as $item)
                <div class="flex items-center justify-between rounded-lg border border-zinc-200 p-4 transition hover:bg-zinc-50 dark:border-zinc-700 dark:hover:bg-zinc-800">
                    <div class="flex items-start gap-3">
                        <div class="rounded-full bg-zinc-100 p-2 dark:bg-zinc-800">
                            <svg class="h-4 w-4 text-zinc-600 dark:text-zinc-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                                <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-zinc-900 dark:text-white">{{ $item->plan?->name }}</p>
                            <div class="mt-1 flex items-center gap-2 text-xs">
                                <span class="rounded-full bg-zinc-100 px-2 py-0.5 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400">
                                    {{ ucfirst($item->status) }}
                                </span>
                                <span class="text-zinc-500">
                                    {{ $item->starts_at->format('M d, Y') }} - {{ $item->ends_at->format('M d, Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-medium text-zinc-900 dark:text-white">₦{{ number_format((float) $item->amount, 2) }}</p>
                        <p class="text-xs text-zinc-500">{{ $item->interval ?? 'monthly' }}</p>
                    </div>
                </div>
            @empty
                <div class="rounded-lg bg-zinc-50 p-8 text-center dark:bg-zinc-800">
                    <svg class="mx-auto h-12 w-12 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-zinc-900 dark:text-white">No History Yet</h3>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Your subscription history will appear here.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
