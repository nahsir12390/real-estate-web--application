<div class="space-y-6">
    <!-- Header with Search and Stats -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30">
                <svg class="h-5 w-5 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">My Favorites</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Manage your saved properties</p>
            </div>
        </div>
        
        <div class="relative">
            <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input
                wire:model.live.debounce.300ms="search"
                type="search"
                placeholder="Search favorite properties..."
                class="w-full rounded-lg border border-zinc-300 py-2 pl-10 pr-4 focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white sm:w-80"
            >
        </div>
    </div>

    <!-- Favorites Grid -->
    @if($favorites->isEmpty())
        <div class="flex flex-col items-center justify-center rounded-xl border border-zinc-200 bg-white py-16 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="relative">
                <svg class="h-24 w-24 text-zinc-300 dark:text-zinc-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                </svg>
                <div class="absolute -right-2 -top-2">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-red-500 text-xs text-white">0</span>
                </div>
            </div>
            <h3 class="mt-4 text-lg font-medium text-zinc-900 dark:text-white">No favorites yet</h3>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Start exploring properties and save your favorites!</p>
            <a href="{{ route('user.home') }}" 
               class="mt-4 rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-red-700">
                Browse Properties
            </a>
        </div>
    @else
        <!-- Desktop Table View (hidden on mobile) -->
        <div class="hidden overflow-hidden rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900 md:block">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800">
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Property</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Location</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Type</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Price</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @foreach($favorites as $favorite)
                            <tr class="transition hover:bg-zinc-50 dark:hover:bg-zinc-800">
                                <td class="px-4 py-3">
                                    @if($favorite->property)
                                        <div class="font-medium text-zinc-900 dark:text-white">{{ $favorite->property->title }}</div>
                                        <div class="text-xs text-zinc-500 dark:text-zinc-400">Added {{ $favorite->created_at->diffForHumans() }}</div>
                                    @else
                                        <span class="text-zinc-500">Property unavailable</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-zinc-700 dark:text-zinc-300">
                                    @if($favorite->property)
                                        {{ $favorite->property->city }}, {{ $favorite->property->state }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($favorite->property)
                                        <span class="rounded-full bg-zinc-100 px-2 py-1 text-xs dark:bg-zinc-800">
                                            {{ ucfirst($favorite->property->property_type) }}
                                        </span>
                                        <span class="ml-1 text-xs text-zinc-500">/ {{ ucfirst($favorite->property->listing_type) }}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($favorite->property)
                                        @php
                                            $statusColors = [
                                                'approved' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                                'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                                'sold' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
                                                'rented' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                            ];
                                            $statusColor = $statusColors[$favorite->property->status] ?? 'bg-zinc-100 text-zinc-800';
                                        @endphp
                                        <span class="rounded-full px-2 py-1 text-xs font-medium {{ $statusColor }}">
                                            {{ ucfirst($favorite->property->status) }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($favorite->property)
                                        <div class="font-medium text-zinc-900 dark:text-white">₦{{ number_format((float) $favorite->property->price) }}</div>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        @if($favorite->property)
                                            <a href="{{ route('user.properties.show', $favorite->property->slug) }}" 
                                               class="rounded-lg bg-blue-600 px-3 py-1.5 text-xs font-medium text-white transition hover:bg-blue-700">
                                                View
                                            </a>
                                        @endif
                                        <button wire:click="removeFavorite({{ $favorite->id }})"
                                                wire:confirm="Are you sure you want to remove this from favorites?"
                                                class="rounded-lg bg-red-600 px-3 py-1.5 text-xs font-medium text-white transition hover:bg-red-700">
                                            Remove
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile Card View (visible on mobile) -->
        <div class="grid gap-4 md:hidden">
            @foreach($favorites as $favorite)
                <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
                    @if($favorite->property)
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="font-semibold text-zinc-900 dark:text-white">{{ $favorite->property->title }}</h3>
                                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $favorite->property->city }}, {{ $favorite->property->state }}
                                </p>
                            </div>
                            <span class="text-xs text-zinc-500">Added {{ $favorite->created_at->diffForHumans() }}</span>
                        </div>

                        <div class="mt-3 flex flex-wrap gap-2">
                            <span class="rounded-full bg-zinc-100 px-2 py-1 text-xs dark:bg-zinc-800">
                                {{ ucfirst($favorite->property->property_type) }}
                            </span>
                            <span class="rounded-full bg-zinc-100 px-2 py-1 text-xs dark:bg-zinc-800">
                                {{ ucfirst($favorite->property->listing_type) }}
                            </span>
                            @php
                                $statusColors = [
                                    'approved' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                    'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                    'sold' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
                                    'rented' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                ];
                                $statusColor = $statusColors[$favorite->property->status] ?? 'bg-zinc-100 text-zinc-800';
                            @endphp
                            <span class="rounded-full px-2 py-1 text-xs font-medium {{ $statusColor }}">
                                {{ ucfirst($favorite->property->status) }}
                            </span>
                        </div>

                        <div class="mt-3 flex items-center justify-between">
                            <div>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400">Price</p>
                                <p class="text-lg font-bold text-red-600 dark:text-red-400">₦{{ number_format((float) $favorite->property->price) }}</p>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('user.properties.show', $favorite->property->slug) }}" 
                                   class="rounded-lg bg-blue-600 px-3 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                                    View
                                </a>
                                <button wire:click="removeFavorite({{ $favorite->id }})"
                                        wire:confirm="Are you sure you want to remove this from favorites?"
                                        class="rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white transition hover:bg-red-700">
                                    Remove
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center justify-between">
                            <span class="text-zinc-500">Property no longer available</span>
                            <button wire:click="removeFavorite({{ $favorite->id }})"
                                    wire:confirm="Are you sure you want to remove this from favorites?"
                                    class="rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white transition hover:bg-red-700">
                                Remove
                            </button>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $favorites->links() }}
        </div>
    @endif
</div>