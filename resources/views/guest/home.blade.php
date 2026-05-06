<x-layouts.guest :title="__('Home')">
    @php
        $saleCount = $properties->where('listing_type', 'sale')->count();
        $rentCount = $properties->where('listing_type', 'rent')->count();
        $heroImage = 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1800&q=85';
    @endphp

    <div class="space-y-16">
        <section class="overflow-hidden rounded-[1.75rem] border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-950">
            <div class="grid lg:grid-cols-[1.02fr_0.98fr]">
                <div class="flex min-h-[560px] flex-col justify-center px-6 py-12 sm:px-10 lg:px-14">
                    <div class="max-w-2xl">
                        <div class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-emerald-700 dark:border-emerald-900/60 dark:bg-emerald-950 dark:text-emerald-300">
                            Verified Nigerian real estate
                        </div>

                        <h1 class="mt-6 text-4xl font-semibold leading-tight tracking-tight text-zinc-950 dark:text-white sm:text-5xl lg:text-6xl">
                            Find a property that fits how you want to live.
                        </h1>

                        <p class="mt-5 max-w-xl text-base leading-7 text-zinc-600 dark:text-zinc-300">
                            Browse approved homes, apartments, and land from verified agents across Nigeria. Compare listings clearly and contact the right agent with confidence.
                        </p>

                        <form action="{{ route('properties.index') }}" method="GET" class="mt-8 rounded-2xl border border-zinc-200 bg-zinc-50 p-3 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                            <div class="grid gap-3 sm:grid-cols-[1fr_auto]">
                                <label class="sr-only" for="home-search">Search properties</label>
                                <input id="home-search" name="search" type="search" placeholder="Search by title, city, or area"
                                       class="h-12 rounded-xl border border-zinc-200 bg-white px-4 text-sm text-zinc-900 outline-none transition focus:border-emerald-500 dark:border-zinc-800 dark:bg-zinc-950 dark:text-white">
                                <button class="inline-flex h-12 items-center justify-center gap-2 rounded-xl bg-zinc-950 px-5 text-sm font-semibold text-white transition hover:bg-emerald-700 dark:bg-white dark:text-zinc-950 dark:hover:bg-emerald-200">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.2-5.2m1.7-4.3a6 6 0 11-12 0 6 6 0 0112 0z" />
                                    </svg>
                                    Search
                                </button>
                            </div>
                        </form>

                        <div class="mt-6 flex flex-wrap gap-3">
                            <a href="{{ route('properties.index') }}" class="rounded-full border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-700 transition hover:border-zinc-950 hover:text-zinc-950 dark:border-zinc-700 dark:text-zinc-300 dark:hover:border-white dark:hover:text-white">
                                Browse all
                            </a>
                            <a href="{{ route('properties.index', ['listing_type' => 'sale']) }}" class="rounded-full border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-700 transition hover:border-zinc-950 hover:text-zinc-950 dark:border-zinc-700 dark:text-zinc-300 dark:hover:border-white dark:hover:text-white">
                                For sale {{ $saleCount ? '('.number_format($saleCount).')' : '' }}
                            </a>
                            <a href="{{ route('properties.index', ['listing_type' => 'rent']) }}" class="rounded-full border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-700 transition hover:border-zinc-950 hover:text-zinc-950 dark:border-zinc-700 dark:text-zinc-300 dark:hover:border-white dark:hover:text-white">
                                For rent {{ $rentCount ? '('.number_format($rentCount).')' : '' }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="relative min-h-[420px] lg:min-h-full">
                    <img src="{{ $heroImage }}" alt="Modern residential home" class="absolute inset-0 h-full w-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-zinc-950/55 via-zinc-950/10 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6 rounded-2xl border border-white/20 bg-white/90 p-5 shadow-xl backdrop-blur dark:bg-zinc-950/85">
                        <p class="text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400">Latest approved listings</p>
                        <div class="mt-3 grid grid-cols-3 gap-3">
                            <div>
                                <p class="text-2xl font-semibold text-zinc-950 dark:text-white">{{ number_format($properties->count()) }}</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">Featured</p>
                            </div>
                            <div>
                                <p class="text-2xl font-semibold text-zinc-950 dark:text-white">{{ number_format($saleCount) }}</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">Sale</p>
                            </div>
                            <div>
                                <p class="text-2xl font-semibold text-zinc-950 dark:text-white">{{ number_format($rentCount) }}</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">Rent</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700 dark:text-emerald-300">Curated listings</p>
                    <h2 class="mt-2 text-3xl font-semibold tracking-tight text-zinc-950 dark:text-white">Featured Properties</h2>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-zinc-600 dark:text-zinc-400">A focused selection of approved listings from verified agents.</p>
                </div>
                <a href="{{ route('properties.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-zinc-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-emerald-700 dark:bg-white dark:text-zinc-950 dark:hover:bg-emerald-200">
                    View all properties
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            @if($properties->count() > 0)
                <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($properties as $property)
                        <article class="group overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg dark:border-zinc-800 dark:bg-zinc-950">
                            <a href="{{ route('properties.show', $property->slug) }}" class="block">
                                <div class="relative aspect-[4/3] overflow-hidden bg-zinc-100 dark:bg-zinc-900">
                                    @if($property->primaryImage?->image_path)
                                        <img src="{{ Storage::url($property->primaryImage->image_path) }}" alt="{{ $property->title }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                    @else
                                        <div class="flex h-full items-center justify-center text-sm text-zinc-500">No image</div>
                                    @endif
                                    <div class="absolute left-3 top-3 rounded-full bg-white/95 px-3 py-1 text-xs font-semibold text-zinc-900 shadow-sm dark:bg-zinc-950/90 dark:text-white">
                                        {{ ucfirst($property->listing_type) }}
                                    </div>
                                </div>
                            </a>
                            <div class="p-4">
                                <div class="flex items-start justify-between gap-3">
                                    <h3 class="line-clamp-2 text-sm font-semibold leading-5 text-zinc-950 dark:text-white">
                                        <a href="{{ route('properties.show', $property->slug) }}">{{ $property->title }}</a>
                                    </h3>
                                    <span class="shrink-0 rounded-full bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300">
                                        {{ ucfirst($property->property_type) }}
                                    </span>
                                </div>

                                <p class="mt-3 text-lg font-semibold text-zinc-950 dark:text-white">&#8358;{{ number_format((float) $property->price) }}</p>
                                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ $property->city }}, {{ $property->state }}</p>

                                <div class="mt-4 flex flex-wrap gap-3 border-t border-zinc-100 pt-4 text-xs text-zinc-600 dark:border-zinc-800 dark:text-zinc-400">
                                    @if($property->bedrooms)
                                        <span>{{ $property->bedrooms }} beds</span>
                                    @endif
                                    @if($property->bathrooms)
                                        <span>{{ $property->bathrooms }} baths</span>
                                    @endif
                                    @if($property->area)
                                        <span>{{ number_format((float) $property->area) }} {{ $property->area_unit }}</span>
                                    @endif
                                </div>

                                <div class="mt-4 flex items-center justify-between gap-3">
                                    <div class="min-w-0">
                                        <p class="truncate text-xs font-medium text-zinc-900 dark:text-white">{{ $property->agent?->user?->name ?? 'Verified Agent' }}</p>
                                        <p class="truncate text-xs text-zinc-500">{{ $property->agent?->company_name ?? 'Real estate agent' }}</p>
                                    </div>
                                    <a href="{{ route('properties.show', $property->slug) }}" class="shrink-0 rounded-lg border border-zinc-200 px-3 py-2 text-xs font-semibold text-zinc-700 transition hover:border-emerald-600 hover:text-emerald-700 dark:border-zinc-800 dark:text-zinc-300">
                                        Details
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="mt-8 rounded-2xl border border-dashed border-zinc-300 bg-zinc-50 p-12 text-center dark:border-zinc-800 dark:bg-zinc-950">
                    <p class="text-lg font-semibold text-zinc-950 dark:text-white">No approved properties yet.</p>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">Approved listings will appear here automatically.</p>
                </div>
            @endif
        </section>

        <section class="rounded-3xl border border-zinc-200 bg-zinc-950 p-8 text-white shadow-sm dark:border-zinc-800 sm:p-10">
            <div class="grid gap-8 lg:grid-cols-[1fr_auto] lg:items-center">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-emerald-300">For agents and buyers</p>
                    <h2 class="mt-2 text-3xl font-semibold tracking-tight">List, review, and discover properties with less friction.</h2>
                    <p class="mt-3 max-w-2xl text-sm leading-6 text-zinc-300">Create an account to save properties, contact agents, or start publishing listings after verification.</p>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row">
                    @if(Route::has('register'))
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-xl bg-white px-5 py-3 text-sm font-semibold text-zinc-950 transition hover:bg-emerald-200">
                            Create account
                        </a>
                    @endif
                    <a href="{{ route('properties.index') }}" class="inline-flex items-center justify-center rounded-xl border border-white/20 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
                        Browse listings
                    </a>
                </div>
            </div>
        </section>
    </div>
</x-layouts.guest>
