<div class="space-y-8">
    <!-- Back Button -->
    <div class="flex items-center gap-3">
        <a href="{{ route('user.home') }}" 
           class="inline-flex items-center gap-2 rounded-xl border border-zinc-200 bg-white px-5 py-2.5 text-sm font-medium text-zinc-700 shadow-sm transition-all hover:bg-zinc-50 hover:shadow dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-300 dark:hover:bg-zinc-800">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Marketplace
        </a>
    </div>

    <!-- Main Property Card -->
    <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-lg dark:border-zinc-700 dark:bg-zinc-900">
        <!-- Property Header with Actions -->
        <div class="border-b border-zinc-200 bg-gradient-to-r from-zinc-50 to-white p-6 dark:border-zinc-700 dark:from-zinc-800 dark:to-zinc-900">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="rounded-full border border-zinc-300 bg-white px-3 py-1 text-xs font-medium text-zinc-700 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-300">
                            {{ ucfirst($property->listing_type) }}
                        </span>
                        <span class="rounded-full bg-zinc-100 px-3 py-1 text-xs font-medium text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                            {{ ucfirst($property->property_type) }}
                        </span>
                        @if($property->is_featured)
                            <span class="rounded-full bg-zinc-800 px-3 py-1 text-xs font-medium text-white dark:bg-zinc-100 dark:text-zinc-900">
                                Featured
                            </span>
                        @endif
                    </div>
                    <h1 class="mt-3 text-3xl font-bold text-zinc-900 dark:text-white">{{ $property->title }}</h1>
                    <p class="mt-2 flex items-center gap-1.5 text-sm text-zinc-600 dark:text-zinc-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ $property->address }}, {{ $property->city }}, {{ $property->state }}
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Price</p>
                    <p class="text-4xl font-bold text-zinc-900 dark:text-white">₦{{ number_format((float) $property->price) }}</p>
                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">{{ $property->price_unit === 'total' ? 'Total Price' : ($property->price_unit === 'per_month' ? 'per month' : 'per year') }}</p>
                </div>
            </div>
        </div>

        <!-- Image Gallery -->
        <div class="p-6">
            <div class="grid gap-4 lg:grid-cols-2">
                <!-- Main Image -->
                <div class="group relative overflow-hidden rounded-xl border border-zinc-200 bg-zinc-100 dark:border-zinc-700 dark:bg-zinc-800">
                    @if($property->images->first()?->image_path)
                        <img
                            src="{{ Storage::url($property->images->sortByDesc('is_primary')->first()->image_path) }}"
                            alt="{{ $property->title }}"
                            class="h-[450px] w-full object-cover transition duration-700 group-hover:scale-110"
                        >
                        <!-- Image Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 transition group-hover:opacity-100"></div>
                    @else
                        <div class="flex h-[450px] items-center justify-center">
                            <svg class="h-20 w-20 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Thumbnail Grid -->
                @if($property->images->count() > 1)
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($property->images->skip(1)->take(4) as $index => $image)
                            <div class="group relative overflow-hidden rounded-xl border border-zinc-200 bg-zinc-100 transition hover:shadow-md dark:border-zinc-700 dark:bg-zinc-800">
                                <img
                                    src="{{ Storage::url($image->image_path) }}"
                                    alt="Property image {{ $index + 2 }}"
                                    class="h-44 w-full cursor-pointer object-cover transition duration-500 group-hover:scale-110"
                                    onclick="openGallery('{{ Storage::url($image->image_path) }}')"
                                >
                                <div class="absolute inset-0 bg-black/0 transition group-hover:bg-black/10"></div>
                            </div>
                        @endforeach
                        
                        <!-- If there are more than 5 images, show a "more" overlay -->
                        @if($property->images->count() > 5)
                            <div class="relative overflow-hidden rounded-xl border border-zinc-200 bg-zinc-800 dark:border-zinc-700">
                                <img
                                    src="{{ Storage::url($property->images->skip(5)->first()->image_path) }}"
                                    alt="More images"
                                    class="h-44 w-full object-cover opacity-50"
                                >
                                <div class="absolute inset-0 flex items-center justify-center bg-black/50">
                                    <span class="text-lg font-bold text-white">+{{ $property->images->count() - 5 }} more</span>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Property Details Grid -->
        <div class="grid gap-8 border-t border-zinc-200 p-6 dark:border-zinc-700 lg:grid-cols-3">
            <!-- Left Column - Key Features & Description -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Key Features -->
                <div>
                    <h2 class="flex items-center gap-2 text-xl font-bold text-zinc-900 dark:text-white">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                        Key Features
                    </h2>
                    <div class="mt-4 grid grid-cols-2 gap-4 sm:grid-cols-3">
                        <div class="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm transition hover:shadow-md dark:border-zinc-700 dark:bg-zinc-800">
                            <svg class="h-6 w-6 text-zinc-700 dark:text-zinc-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                                <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" />
                            </svg>
                            <p class="mt-2 text-xs font-medium text-zinc-500 dark:text-zinc-400">Bedrooms</p>
                            <p class="text-lg font-bold text-zinc-900 dark:text-white">{{ $property->bedrooms ?? 'N/A' }}</p>
                        </div>
                        <div class="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm transition hover:shadow-md dark:border-zinc-700 dark:bg-zinc-800">
                            <svg class="h-6 w-6 text-zinc-700 dark:text-zinc-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 4a1 1 0 00-1 1v1H3a1 1 0 000 2h1v6a2 2 0 002 2h8a2 2 0 002-2V8h1a1 1 0 100-2h-1V5a1 1 0 00-1-1H5zm7 2v1h-2V6h2zM8 6v1H6V6h2z" clip-rule="evenodd" />
                            </svg>
                            <p class="mt-2 text-xs font-medium text-zinc-500 dark:text-zinc-400">Bathrooms</p>
                            <p class="text-lg font-bold text-zinc-900 dark:text-white">{{ $property->bathrooms ?? 'N/A' }}</p>
                        </div>
                        <div class="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm transition hover:shadow-md dark:border-zinc-700 dark:bg-zinc-800">
                            <svg class="h-6 w-6 text-zinc-700 dark:text-zinc-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z" />
                            </svg>
                            <p class="mt-2 text-xs font-medium text-zinc-500 dark:text-zinc-400">Garages</p>
                            <p class="text-lg font-bold text-zinc-900 dark:text-white">{{ $property->garages ?? 'N/A' }}</p>
                        </div>
                        <div class="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm transition hover:shadow-md dark:border-zinc-700 dark:bg-zinc-800">
                            <svg class="h-6 w-6 text-zinc-700 dark:text-zinc-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd" />
                            </svg>
                            <p class="mt-2 text-xs font-medium text-zinc-500 dark:text-zinc-400">Area</p>
                            <p class="text-lg font-bold text-zinc-900 dark:text-white">{{ $property->area ? $property->area.' '.$property->area_unit : 'N/A' }}</p>
                        </div>
                        <div class="rounded-xl border border-zinc-200 bg-white p-4 shadow-sm transition hover:shadow-md dark:border-zinc-700 dark:bg-zinc-800">
                            <svg class="h-6 w-6 text-zinc-700 dark:text-zinc-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                            </svg>
                            <p class="mt-2 text-xs font-medium text-zinc-500 dark:text-zinc-400">Year Built</p>
                            <p class="text-lg font-bold text-zinc-900 dark:text-white">{{ $property->year_built ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <h2 class="flex items-center gap-2 text-xl font-bold text-zinc-900 dark:text-white">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                        Description
                    </h2>
                    <div class="mt-3 rounded-xl bg-zinc-50 p-5 text-zinc-700 dark:bg-zinc-800/50 dark:text-zinc-300">
                        {{ $property->description }}
                    </div>
                </div>

                <!-- Amenities -->
                @if($property->amenities && count($property->amenities) > 0)
                    <div>
                        <h2 class="flex items-center gap-2 text-xl font-bold text-zinc-900 dark:text-white">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                            Amenities
                        </h2>
                        <div class="mt-3 flex flex-wrap gap-2">
                            @foreach($property->amenities as $amenity)
                                <span class="rounded-full border border-zinc-300 bg-white px-4 py-2 text-sm font-medium text-zinc-700 shadow-sm dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-300">
                                    {{ $amenity }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Column - Agent Info (Sticky) -->
            <div class="lg:col-span-1">
                <div class="sticky top-6 rounded-xl border border-zinc-200 bg-gradient-to-b from-zinc-50 to-white p-6 shadow-lg dark:border-zinc-700 dark:from-zinc-800 dark:to-zinc-900">
                    <h2 class="flex items-center gap-2 text-xl font-bold text-zinc-900 dark:text-white">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Agent Information
                    </h2>
                    
                    <div class="mt-6 flex items-center gap-4">
                        <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-gradient-to-br from-zinc-700 to-zinc-900 text-2xl font-bold text-white shadow-lg dark:from-zinc-100 dark:to-zinc-300 dark:text-zinc-900">
                            {{ substr($property->agent?->user?->name ?? 'A', 0, 2) }}
                        </div>
                        <div>
                            <p class="text-lg font-bold text-zinc-900 dark:text-white">{{ $property->agent?->user?->name ?? 'Unknown Agent' }}</p>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ $property->agent?->company_name ?? 'Independent Agent' }}</p>
                            @if($property->agent?->experience_years)
                                <p class="mt-1 inline-block rounded-full bg-zinc-100 px-3 py-1 text-xs font-medium text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                    {{ $property->agent->experience_years }} years experience
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="mt-6 space-y-3 border-t border-zinc-200 pt-6 dark:border-zinc-700">
                        <div class="flex items-center gap-3 text-sm">
                            <div class="rounded-lg bg-zinc-100 p-2 dark:bg-zinc-800">
                                <svg class="h-4 w-4 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <span class="text-zinc-700 dark:text-zinc-300">{{ $property->agent?->user?->email ?: 'No email provided' }}</span>
                        </div>
                        
                        @if($property->agent?->user?->profile?->phone)
                            <div class="flex items-center gap-3 text-sm">
                                <div class="rounded-lg bg-zinc-100 p-2 dark:bg-zinc-800">
                                    <svg class="h-4 w-4 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <a href="tel:{{ $property->agent->user->profile->phone }}" class="text-zinc-700 hover:text-zinc-900 dark:text-zinc-300 dark:hover:text-white">
                                    {{ $property->agent->user->profile->phone }}
                                </a>
                            </div>
                        @endif

                        @if($property->agent?->user?->profile?->whatsapp_number)
                            <div class="flex items-center gap-3 text-sm">
                                <div class="rounded-lg bg-zinc-100 p-2 dark:bg-zinc-800">
                                    <svg class="h-4 w-4 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </div>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $property->agent->user->profile->whatsapp_number) }}" target="_blank" rel="noopener" class="text-zinc-700 hover:text-zinc-900 dark:text-zinc-300 dark:hover:text-white">
                                    {{ $property->agent->user->profile->whatsapp_number }}
                                </a>
                            </div>
                        @endif
                    </div>

                    @if($property->agent?->specialization)
                        <div class="mt-4 rounded-lg bg-zinc-100 p-4 dark:bg-zinc-800">
                            <p class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Specialization</p>
                            <p class="mt-1 text-sm font-medium text-zinc-900 dark:text-white">{{ $property->agent->specialization }}</p>
                        </div>
                    @endif

                    <!-- Contact Agent Button -->
                    <div class="mt-6">
                        <a href="#inquiry-form" 
                           class="flex w-full items-center justify-center gap-2 rounded-xl bg-zinc-900 py-3 text-sm font-semibold text-white transition hover:bg-zinc-800 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-300">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Contact Agent
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Comments and Inquiry Section -->
    <div class="grid gap-6 lg:grid-cols-2">
        <!-- Comments Section -->
        <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-lg dark:border-zinc-700 dark:bg-zinc-900">
            <h3 class="flex items-center gap-2 text-xl font-bold text-zinc-900 dark:text-white">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                Comments ({{ $comments->count() }})
            </h3>

            <!-- Comment Form -->
            <form wire:submit="addComment" class="mt-4">
                <textarea wire:model="comment" rows="3" 
                          class="w-full rounded-xl border border-zinc-300 px-4 py-3 text-sm focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                          placeholder="Share your thoughts about this property..."></textarea>
                @error('comment') 
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
                <div class="mt-3 flex justify-end">
                    <button type="submit" 
                            class="inline-flex items-center gap-2 rounded-xl bg-zinc-900 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-zinc-800 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-300">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        Post Comment
                    </button>
                </div>
            </form>

            <!-- Comments List -->
            <div class="mt-6 space-y-4">
                @forelse($comments as $item)
                    <div class="rounded-xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-700 dark:bg-zinc-800">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-zinc-700 to-zinc-900 text-sm font-bold text-white dark:from-zinc-100 dark:to-zinc-300 dark:text-zinc-900">
                                    {{ substr($item->user->name, 0, 2) }}
                                </div>
                                <div>
                                    <p class="font-medium text-zinc-900 dark:text-white">{{ $item->user->name }}</p>
                                    <p class="text-xs text-zinc-500">{{ $item->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                        <p class="mt-3 text-sm text-zinc-700 dark:text-zinc-300">{{ $item->comment }}</p>
                    </div>
                @empty
                    <div class="py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <p class="mt-4 text-sm text-zinc-500">No comments yet. Be the first to comment!</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Inquiry Form -->
        <div id="inquiry-form" class="rounded-xl border border-zinc-200 bg-white p-6 shadow-lg dark:border-zinc-700 dark:bg-zinc-900">
            <h3 class="flex items-center gap-2 text-xl font-bold text-zinc-900 dark:text-white">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Send Inquiry to Agent
            </h3>

            @if (session('inquiry_status'))
                <div class="mt-4 rounded-xl border border-green-300 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-800 dark:bg-green-900/30 dark:text-green-300">
                    {{ session('inquiry_status') }}
                </div>
            @endif

            <form wire:submit="sendInquiry" class="mt-6 space-y-5">
                <!-- User Info (Read-only) -->
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-xs font-medium text-zinc-600 dark:text-zinc-400">Your Name</label>
                        <div class="rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-3 text-sm text-zinc-700 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                            {{ auth()->user()->name }}
                        </div>
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-medium text-zinc-600 dark:text-zinc-400">Your Email</label>
                        <div class="rounded-xl border border-zinc-200 bg-zinc-50 px-4 py-3 text-sm text-zinc-700 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                            {{ auth()->user()->email }}
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-xs font-medium text-zinc-600 dark:text-zinc-400">
                            Phone Number <span class="text-zinc-400">(optional)</span>
                        </label>
                        <input wire:model="phone" type="text" 
                               class="w-full rounded-xl border border-zinc-300 px-4 py-3 text-sm focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                               placeholder="e.g., 08012345678">
                        @error('phone') 
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1.5 block text-xs font-medium text-zinc-600 dark:text-zinc-400">Preferred Contact</label>
                        <select wire:model="preferred_contact" 
                                class="w-full rounded-xl border border-zinc-300 px-4 py-3 text-sm focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                            <option value="email">Email</option>
                            <option value="phone">Phone</option>
                            <option value="whatsapp">WhatsApp</option>
                        </select>
                    </div>
                </div>

                <!-- Message -->
                <div>
                    <label class="mb-1.5 block text-xs font-medium text-zinc-600 dark:text-zinc-400">Your Message</label>
                    <textarea wire:model="message" rows="5" 
                              class="w-full rounded-xl border border-zinc-300 px-4 py-3 text-sm focus:border-zinc-500 focus:outline-none focus:ring-1 focus:ring-zinc-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"
                              placeholder="Tell the agent about your interest, ask questions, or request more information..."></textarea>
                    @error('message') 
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full rounded-xl bg-zinc-900 py-3.5 text-sm font-semibold text-white transition hover:bg-zinc-800 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-300">
                    Send Inquiry to Agent
                </button>

                <p class="text-center text-xs text-zinc-500">
                    The agent will respond to you via your preferred contact method within 24 hours.
                </p>
            </form>
        </div>
    </div>

    <!-- Image Gallery Modal (for full-screen view) -->
    <div id="galleryModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/95 p-4">
        <button onclick="closeGallery()" class="absolute right-4 top-4 rounded-full bg-white/10 p-2 text-white backdrop-blur-sm transition hover:bg-white/20">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <img id="galleryImage" src="" alt="Property image" class="max-h-[85vh] max-w-full rounded-xl shadow-2xl">
    </div>

    <script>
        function openGallery(imageUrl) {
            document.getElementById('galleryImage').src = imageUrl;
            document.getElementById('galleryModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeGallery() {
            document.getElementById('galleryModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Close modal with escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeGallery();
            }
        });
    </script>
</div>