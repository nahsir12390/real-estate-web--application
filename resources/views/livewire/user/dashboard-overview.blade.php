<div class="space-y-6">
    @if (session('favorite_status'))
        <div class="rounded-lg border border-green-300 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-800 dark:bg-green-900/30 dark:text-green-300">
            {{ session('favorite_status') }}
        </div>
    @endif

    <!-- Welcome Section -->
   

    <!-- Stats Grid -->
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Saved Properties -->
        <div class="group relative rounded-xl border border-zinc-200 bg-white p-6 transition-all hover:shadow-lg dark:border-zinc-700 dark:bg-zinc-900">
            <div class="absolute right-4 top-4 opacity-10 transition group-hover:scale-110 group-hover:opacity-20">
                <svg class="h-12 w-12 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
            </div>
            <div class="relative">
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Saved Properties</p>
                <p class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">{{ number_format($stats['favorites']) }}</p>
                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-500">Properties you've saved</p>
            </div>
            <div class="absolute bottom-0 left-0 h-1 w-0 bg-red-500 transition-all group-hover:w-full"></div>
        </div>

        <!-- My Inquiries -->
        <div class="group relative rounded-xl border border-zinc-200 bg-white p-6 transition-all hover:shadow-lg dark:border-zinc-700 dark:bg-zinc-900">
            <div class="absolute right-4 top-4 opacity-10 transition group-hover:scale-110 group-hover:opacity-20">
                <svg class="h-12 w-12 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20 2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h14l4 4V4c0-1.1-.9-2-2-2zm-3 12H7c-.55 0-1-.45-1-1s.45-1 1-1h10c.55 0 1 .45 1 1s-.45 1-1 1zm0-3H7c-.55 0-1-.45-1-1s.45-1 1-1h10c.55 0 1 .45 1 1s-.45 1-1 1zm0-3H7c-.55 0-1-.45-1-1s.45-1 1-1h10c.55 0 1 .45 1 1s-.45 1-1 1z"/>
                </svg>
            </div>
            <div class="relative">
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">My Inquiries</p>
                <p class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">{{ number_format($stats['inquiries']) }}</p>
                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-500">Messages sent to agents</p>
            </div>
            <div class="absolute bottom-0 left-0 h-1 w-0 bg-blue-500 transition-all group-hover:w-full"></div>
        </div>

        <!-- My Reports -->
        <div class="group relative rounded-xl border border-zinc-200 bg-white p-6 transition-all hover:shadow-lg dark:border-zinc-700 dark:bg-zinc-900">
            <div class="absolute right-4 top-4 opacity-10 transition group-hover:scale-110 group-hover:opacity-20">
                <svg class="h-12 w-12 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                </svg>
            </div>
            <div class="relative">
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">My Reports</p>
                <p class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">{{ number_format($stats['reports']) }}</p>
                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-500">Issues you've reported</p>
            </div>
            <div class="absolute bottom-0 left-0 h-1 w-0 bg-yellow-500 transition-all group-hover:w-full"></div>
        </div>

        <!-- Profile Status -->
        <div class="group relative rounded-xl border border-zinc-200 bg-white p-6 transition-all hover:shadow-lg dark:border-zinc-700 dark:bg-zinc-900">
            <div class="absolute right-4 top-4 opacity-10 transition group-hover:scale-110 group-hover:opacity-20">
                <svg class="h-12 w-12 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                </svg>
            </div>
            <div class="relative">
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Profile Status</p>
                <div class="mt-2 flex items-center gap-2">
                    <p class="text-3xl font-bold {{ $stats['profile_complete'] ? 'text-green-600 dark:text-green-400' : 'text-yellow-600 dark:text-yellow-400' }}">
                        {{ $stats['profile_complete'] ? 'Complete' : 'Incomplete' }}
                    </p>
                    @if(!$stats['profile_complete'])
                        <span class="rounded-full bg-yellow-100 px-2 py-0.5 text-xs font-medium text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                            Action Needed
                        </span>
                    @endif
                </div>
                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-500">
                    @if($stats['profile_complete'])
                        Your profile is complete
                    @else
                        <a href="{{ route('profile.edit') }}" class="text-blue-600 hover:underline dark:text-blue-400">Complete your profile</a>
                    @endif
                </p>
            </div>
            <div class="absolute bottom-0 left-0 h-1 w-0 {{ $stats['profile_complete'] ? 'bg-green-500' : 'bg-yellow-500' }} transition-all group-hover:w-full"></div>
        </div>
    </div>

    <!-- Marketplace Section -->
    <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
        <!-- Header with Search -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Marketplace</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Browse approved properties available for purchase</p>
            </div>
            <div class="relative">
                <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input
                    wire:model.live.debounce.300ms="search"
                    type="search"
                    placeholder="Search by title, location..."
                    class="w-full rounded-lg border border-zinc-300 py-2 pl-10 pr-4 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white sm:w-80"
                >
            </div>
        </div>

        <!-- Properties Grid -->
        @if($marketplaceProperties->isEmpty())
            <div class="mt-8 flex flex-col items-center justify-center py-12">
                <svg class="h-16 w-16 text-zinc-300 dark:text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-zinc-900 dark:text-white">No properties found</h3>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Try adjusting your search or check back later for new listings.</p>
                @if($search)
                    <button wire:click="$set('search', '')" class="mt-4 rounded-lg bg-zinc-100 px-4 py-2 text-sm font-medium text-zinc-700 hover:bg-zinc-200 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700">
                        Clear Search
                    </button>
                @endif
            </div>
        @else
            <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach($marketplaceProperties as $property)
                    <article class="group relative overflow-hidden rounded-xl border border-zinc-200 bg-white transition-all hover:shadow-lg dark:border-zinc-700 dark:bg-zinc-800">
                        <!-- Image Container -->
                        <div class="relative h-48 w-full overflow-hidden bg-zinc-100 dark:bg-zinc-700">
                            @if($property->primaryImage?->image_path)
                                <img
                                    src="{{ Storage::url($property->primaryImage->image_path) }}"
                                    alt="{{ $property->title }}"
                                    class="h-full w-full object-cover transition duration-300 group-hover:scale-110"
                                >
                            @else
                                <div class="flex h-full items-center justify-center">
                                    <svg class="h-12 w-12 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            
                            <!-- Property Type Badge -->
                            <span class="absolute left-3 top-3 rounded-full bg-black/50 px-2 py-1 text-xs font-medium text-white backdrop-blur-sm">
                                {{ ucfirst($property->property_type) }}
                            </span>
                            
                            <!-- Favorite Button -->
                            @php($isFavorited = in_array((int) $property->id, $favoritePropertyIds, true))
                            <button
                                type="button"
                                wire:click="toggleFavorite({{ $property->id }})"
                                class="absolute right-3 top-3 rounded-full bg-white/80 p-1.5 backdrop-blur-sm transition hover:bg-white dark:bg-zinc-800/80 dark:hover:bg-zinc-800 {{ $isFavorited ? 'text-red-600' : 'text-zinc-500' }}"
                                title="{{ $isFavorited ? 'Remove from favorites' : 'Add to favorites' }}"
                            >
                                <svg class="h-4 w-4" fill="{{ $isFavorited ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.8" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>

                        <!-- Content -->
                        <div class="p-4">
                            <div class="mb-2">
                                <h3 class="font-semibold text-zinc-900 line-clamp-1 dark:text-white">{{ $property->title }}</h3>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                    {{ $property->city }}, {{ $property->state }}
                                </p>
                            </div>

                            <!-- Price -->
                            <div class="mb-3">
                                <p class="text-lg font-bold text-blue-600 dark:text-blue-400">
                                    ₦{{ number_format((float) $property->price) }}
                                </p>
                                <p class="text-xs text-zinc-500">{{ $property->price_unit }}</p>
                            </div>

                            <!-- Features -->
                            <div class="mb-3 flex gap-3 text-xs text-zinc-600 dark:text-zinc-400">
                                @if($property->bedrooms)
                                    <span class="flex items-center gap-1">
                                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                                            <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $property->bedrooms }} Beds
                                    </span>
                                @endif
                                @if($property->bathrooms)
                                    <span class="flex items-center gap-1">
                                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5 4a1 1 0 00-1 1v1H3a1 1 0 000 2h1v6a2 2 0 002 2h8a2 2 0 002-2V8h1a1 1 0 100-2h-1V5a1 1 0 00-1-1H5zm7 2v1h-2V6h2zM8 6v1H6V6h2z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $property->bathrooms }} Baths
                                    </span>
                                @endif
                                @if($property->area)
                                    <span class="flex items-center gap-1">
                                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $property->area }} {{ $property->area_unit }}
                                    </span>
                                @endif
                            </div>

                            <!-- Agent Info -->
                            <div class="rounded-lg bg-zinc-50 p-3 dark:bg-zinc-700/50">
                                <p class="text-xs font-medium text-zinc-900 dark:text-white">{{ $property->agent?->user?->name ?? 'Unknown Agent' }}</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $property->agent?->company_name ?? 'Independent Agent' }}</p>
                                <div class="mt-1 flex items-center gap-1 text-xs text-zinc-500 dark:text-zinc-400">
                                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <span class="truncate">{{ $property->agent?->user?->email ?: 'No email' }}</span>
                                </div>
                            </div>

                            <!-- Action Button -->
                            <a href="{{ route('user.properties.show', $property->slug) }}" 
                               class="mt-3 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-zinc-900 px-3 py-2 text-sm font-medium text-white transition hover:bg-zinc-800 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-300">
                                View Details
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $marketplaceProperties->links() }}
            </div>
        @endif
    </div>
</div>
