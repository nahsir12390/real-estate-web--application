<div class="space-y-6">
    <!-- Navigation Button -->
    <div class="flex justify-end">
        <a href="{{ route('agent.dashboard') }}"
           class="inline-flex items-center rounded-md bg-zinc-900 px-3 py-1.5 text-sm font-medium text-white hover:bg-zinc-700 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-300">
            <svg class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Dashboard
        </a>
    </div>

    @if($subscriptionNotice && $subscriptionNotice['show'])
        <div class="rounded-xl border-l-4 border-zinc-700 bg-zinc-100 p-4 dark:border-zinc-500 dark:bg-zinc-900">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ __('Subscription Required') }}</h3>
                    <p class="mt-1 text-sm text-zinc-700 dark:text-zinc-300">
                        {{ $subscriptionNotice['message'] }}
                    </p>
                </div>
                <a href="{{ route('agent.subscription') }}"
                   class="inline-flex items-center rounded-md bg-zinc-900 px-3 py-1.5 text-sm font-medium text-white hover:bg-zinc-700 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-300">
                    {{ __('View Plans') }}
                </a>
            </div>
        </div>
    @endif

    <!-- Verification Warning Banner -->
    @if($verificationStatus['needs_verification'])
        <div class="rounded-xl border-l-4 border-yellow-500 bg-yellow-50 p-4 dark:border-yellow-600 dark:bg-yellow-900/20">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-600 dark:text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-300">
                        @if($verificationStatus['warning_type'] === 'rejected')
                            {{ __('Verification Rejected') }}
                        @elseif($verificationStatus['warning_type'] === 'not_submitted')
                            {{ __('Verification Required') }}
                        @else
                            {{ __('Attention Required') }}
                        @endif
                    </h3>
                    <p class="mt-1 text-sm text-yellow-700 dark:text-yellow-400">
                        {{ $verificationStatus['message'] }}
                    </p>
                    <div class="mt-3">
                        <a href="{{ route('agent.verification') }}" 
                           class="inline-flex items-center rounded-md bg-yellow-100 px-3 py-1.5 text-sm font-medium text-yellow-800 hover:bg-yellow-200 dark:bg-yellow-800/30 dark:text-yellow-300 dark:hover:bg-yellow-800/50">
                            @if($verificationStatus['warning_type'] === 'rejected')
                                {{ __('Submit New Documents') }}
                            @else
                                {{ __('Complete Verification') }}
                            @endif
                            <svg class="ml-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @elseif($verificationStatus['warning_type'] === 'pending')
        <div class="rounded-xl border-l-4 border-blue-500 bg-blue-50 p-4 dark:border-blue-600 dark:bg-blue-900/20">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-sm font-medium text-blue-800 dark:text-blue-300">
                        {{ __('Verification Pending') }}
                    </h3>
                    <p class="mt-1 text-sm text-blue-700 dark:text-blue-400">
                        {{ $verificationStatus['message'] }}
                    </p>
                    <p class="mt-2 text-xs text-blue-600 dark:text-blue-500">
                        Submitted on: {{ $verificationStatus['latest_submission']->created_at->format('M d, Y') }}
                    </p>
                </div>
            </div>
        </div>
    @elseif($verificationStatus['warning_type'] === 'approved')
        <div class="rounded-xl border-l-4 border-green-500 bg-green-50 p-4 dark:border-green-600 dark:bg-green-900/20">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-600 dark:text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-sm font-medium text-green-800 dark:text-green-300">
                        {{ __('Account Verified') }}
                    </h3>
                    <p class="mt-1 text-sm text-green-700 dark:text-green-400">
                        {{ $verificationStatus['message'] }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Stats Grid -->
    <div class="grid gap-4 md:grid-cols-4">
        <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
            <p class="text-xs text-zinc-500">Total Properties</p>
            <p class="text-2xl font-semibold">{{ $stats['total_properties'] }}</p>
        </div>
        <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
            <p class="text-xs text-zinc-500">Pending Review</p>
            <p class="text-2xl font-semibold">{{ $stats['pending_properties'] }}</p>
        </div>
        <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
            <p class="text-xs text-zinc-500">Approved Listings</p>
            <p class="text-2xl font-semibold">{{ $stats['approved_properties'] }}</p>
        </div>
        <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
            <p class="text-xs text-zinc-500">New Inquiries</p>
            <p class="text-2xl font-semibold">{{ $stats['new_inquiries'] }}</p>
        </div>
    </div>

    <!-- Quota Information -->
    <div class="rounded-xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-700 dark:bg-zinc-900">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold">Listing Quota</h2>
                @php
                    $limit = (int) ($quota['listing_limit'] ?? 0);
                    $remaining = (int) ($quota['remaining_slots'] ?? 0);
                    $hasSubscription = (bool) ($quota['has_subscription'] ?? false);
                @endphp
                <p class="mt-1 text-sm text-zinc-500">
                    @if($hasSubscription)
                        {{ $remaining }} slot{{ $remaining === 1 ? '' : 's' }} remaining out of {{ $limit }}.
                    @else
                        Free plan: {{ $remaining }} sale slot{{ $remaining === 1 ? '' : 's' }} remaining.
                    @endif
                </p>
            </div>
            @if(!$verificationStatus['needs_verification'] && $verificationStatus['warning_type'] === 'approved')
                <a href="{{ route('agent.properties.create') }}" 
                   class="inline-flex items-center rounded-md bg-blue-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-blue-700">
                    <svg class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add New Property
                </a>
            @endif
        </div>
        
        <!-- Progress Bar -->
        @if(($quota['listing_limit'] ?? 0) > 0)
            @php
                $percentage = min(100, (($quota['listing_limit'] - $quota['remaining_slots']) / $quota['listing_limit']) * 100);
            @endphp
            <div class="mt-3 h-2 w-full rounded-full bg-zinc-200 dark:bg-zinc-700">
                <div class="h-2 rounded-full bg-blue-600" style="width: {{ $percentage }}%"></div>
            </div>
        @endif
    </div>

    <!-- Quick Actions based on verification status -->
    @if($verificationStatus['needs_verification'])
        <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
            <h3 class="font-semibold">Next Steps</h3>
            <p class="mt-1 text-sm text-zinc-500">Complete these steps to start listing properties:</p>
            <ul class="mt-3 space-y-2">
                <li class="flex items-center gap-2 text-sm">
                    <span class="flex h-5 w-5 items-center justify-center rounded-full bg-yellow-100 text-xs font-medium text-yellow-800 dark:bg-yellow-800/30 dark:text-yellow-300">1</span>
                    <span>Submit verification documents</span>
                </li>
                <li class="flex items-center gap-2 text-sm text-zinc-400">
                    <span class="flex h-5 w-5 items-center justify-center rounded-full bg-zinc-100 text-xs font-medium text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400">2</span>
                    <span>Wait for admin approval</span>
                </li>
                <li class="flex items-center gap-2 text-sm text-zinc-400">
                    <span class="flex h-5 w-5 items-center justify-center rounded-full bg-zinc-100 text-xs font-medium text-zinc-500 dark:bg-zinc-800 dark:text-zinc-400">3</span>
                    <span>Start listing properties</span>
                </li>
            </ul>
        </div>
    @endif
</div>
