<x-layouts.guest :title="__('Properties')">
    <!-- Page Header -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-black via-zinc-900 to-black p-8 text-white shadow-lg dark:from-black dark:via-zinc-950 dark:to-black mb-8">
        <!-- Decorative Background -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 h-80 w-80 rounded-full bg-orange-500/20 blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 h-80 w-80 rounded-full bg-red-500/20 blur-3xl"></div>
        </div>

        <div class="relative">
            <h1 class="text-4xl font-bold tracking-tight sm:text-5xl">
                Explore Properties
            </h1>
            <p class="mt-3 max-w-2xl text-lg text-gray-300">
                Browse our collection of approved properties and find your perfect home or investment opportunity.
            </p>

            <!-- Search Bar -->
            <div class="mt-6 flex gap-2">
                <form method="GET" action="{{ route('properties.index') }}" class="w-full max-w-md">
                    <div class="relative">
                        <input
                            type="search"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Search by title, location..."
                            class="w-full rounded-lg border border-orange-500/30 bg-white/10 px-4 py-3 text-white placeholder-white/50 backdrop-blur-sm transition focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-400/50"
                        >
                        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-orange-400 hover:text-orange-300">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Properties Grid -->
    <div class="space-y-8">
        @if($properties->isNotEmpty())
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @forelse($properties as $property)
                    <article class="group relative overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-lg transition-all hover:-translate-y-1 hover:shadow-xl dark:border-zinc-700 dark:bg-zinc-900">
                        <!-- Image Container -->
                        <div class="relative h-48 w-full overflow-hidden bg-zinc-100 dark:bg-zinc-800">
                            @if($property->primaryImage?->image_path)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($property->primaryImage->image_path) }}" alt="{{ $property->title }}" class="h-full w-full object-cover transition group-hover:scale-105">
                            @else
                                <div class="flex h-full items-center justify-center">
                                    <svg class="h-12 w-12 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif

                            <!-- Property Type Badge -->
                            <div class="absolute left-3 top-3 flex gap-2">
                                <span class="rounded-full bg-gradient-to-r from-orange-500 to-red-500 px-3 py-1 text-xs font-semibold text-white shadow-lg">
                                    {{ ucfirst($property->listing_type) }}
                                </span>
                                <span class="rounded-full bg-black/50 px-3 py-1 text-xs font-semibold text-white backdrop-blur-sm">
                                    {{ ucfirst($property->property_type) }}
                                </span>
                            </div>

                            <!-- Quick Stats -->
                            @if($property->bedrooms || $property->bathrooms)
                                <div class="absolute bottom-3 left-3 right-3 flex gap-2 text-xs font-medium text-white">
                                    @if($property->bedrooms)
                                        <div class="flex items-center gap-1 rounded-lg bg-black/60 px-2 py-1 backdrop-blur-sm">
                                            <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                            </svg>
                                            {{ $property->bedrooms }}
                                        </div>
                                    @endif
                                    @if($property->bathrooms)
                                        <div class="flex items-center gap-1 rounded-lg bg-black/60 px-2 py-1 backdrop-blur-sm">
                                            <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a1 1 0 001 1h12a1 1 0 001-1V6a2 2 0 00-2-2H4zm0 6a1 1 0 000 2h.01a1 1 0 100-2H4zm4 0a1 1 0 000 2h4.01a1 1 0 100-2H8zm6-3a1 1 0 11-2 0 1 1 0 012 0zM5 1a1 1 0 000 2h10a1 1 0 000-2H5z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $property->bathrooms }}
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="p-4">
                            <!-- Title -->
                            <h3 class="line-clamp-2 font-semibold text-zinc-900 dark:text-white group-hover:text-orange-600 dark:group-hover:text-orange-400 transition">
                                {{ $property->title }}
                            </h3>

                            <!-- Location -->
                            <div class="mt-2 flex items-center gap-1 text-xs text-zinc-600 dark:text-zinc-400">
                                <svg class="h-4 w-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ $property->city }}, {{ $property->state }}
                            </div>

                            <!-- Price -->
                            <div class="mt-3 rounded-lg bg-gradient-to-r from-orange-500/10 to-red-500/10 p-3">
                                <p class="text-xs text-zinc-600 dark:text-zinc-400">Price</p>
                                <p class="mt-1 text-lg font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent">
                                    ₦{{ number_format((float) $property->price) }}
                                </p>
                            </div>

                            <!-- Agent Info -->
                            @if($property->agent?->user)
                                <div class="mt-3 flex items-center gap-2 border-t border-zinc-200 pt-3 dark:border-zinc-700">
                                    @if($property->agent?->user?->profile?->avatar)
                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($property->agent->user->profile->avatar) }}" alt="" class="h-8 w-8 rounded-full object-cover border border-orange-500/50">
                                    @else
                                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-br from-orange-400 to-red-500 text-xs font-bold text-white">
                                            {{ substr($property->agent->user->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-medium text-zinc-900 dark:text-white truncate">{{ $property->agent->user->name }}</p>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Agent</p>
                                    </div>
                                </div>
                            @endif

                            <!-- View Details Button -->
                            <a href="{{ route('properties.show', $property->slug) }}" class="mt-3 block w-full rounded-lg bg-gradient-to-r from-orange-500 to-red-500 py-2 text-center text-sm font-medium text-white transition hover:shadow-lg hover:from-orange-600 hover:to-red-600">
                                View Details
                            </a>
                        </div>
                    </article>
                @empty
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $properties->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="flex flex-col items-center justify-center rounded-2xl border-2 border-dashed border-zinc-300 bg-zinc-50 py-16 dark:border-zinc-700 dark:bg-zinc-900">
                <svg class="h-16 w-16 text-zinc-400 dark:text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M3 12l9 9 9-9" />
                </svg>
                <h3 class="mt-4 text-lg font-semibold text-zinc-900 dark:text-white">No Properties Found</h3>
                <p class="mt-2 text-center text-sm text-zinc-600 dark:text-zinc-400">
                    Try adjusting your search or filters to find properties
                </p>
                <a href="{{ route('properties.index') }}" class="mt-4 rounded-lg bg-gradient-to-r from-orange-500 to-red-500 px-6 py-2 text-sm font-medium text-white transition hover:shadow-lg">
                    View All Properties
                </a>
            </div>
        @endif
    </div>
</x-layouts.guest>
