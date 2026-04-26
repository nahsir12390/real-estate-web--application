<x-layouts.guest :title="__('Home')">
    <!-- Hero Section - Modern & Stylish -->
    <div class="relative overflow-hidden bg-gradient-to-br from-black via-zinc-900 to-black dark:from-black dark:via-zinc-950 dark:to-black">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <!-- Gradient Orbs -->
            <div class="absolute -top-40 -right-40 h-80 w-80 animate-pulse rounded-full bg-purple-500/30 blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 h-80 w-80 animate-pulse rounded-full bg-blue-500/30 blur-3xl" style="animation-delay: 1s"></div>
            <div class="absolute top-1/2 left-1/2 h-96 w-96 -translate-x-1/2 -translate-y-1/2 rounded-full bg-indigo-500/20 blur-3xl"></div>
            
            <!-- Floating Shapes -->
            <div class="absolute left-10 top-20 h-20 w-20 animate-float rounded-full border border-white/10 bg-white/5 backdrop-blur-sm"></div>
            <div class="absolute right-10 bottom-20 h-32 w-32 animate-float rounded-lg border border-white/10 bg-white/5 backdrop-blur-sm" style="animation-delay: 2s; animation-duration: 8s;"></div>
            <div class="absolute left-1/4 bottom-10 h-16 w-16 animate-float border border-white/10 bg-white/5 backdrop-blur-sm" style="animation-delay: 1.5s; transform: rotate(45deg);"></div>
            
            <!-- Grid Pattern -->
            <svg class="absolute inset-0 h-full w-full opacity-20">
                <defs>
                    <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M 40 0 L 0 0 0 40" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)" />
            </svg>
            
            <!-- Particles (CSS-only animation) -->
            <div class="stars"></div>
        </div>

        <!-- Hero Content -->
        <div class="relative mx-auto max-w-7xl px-4 py-32 sm:px-6 lg:px-8 lg:py-40">
            <div class="text-center">
                <!-- Badge -->
                <div class="mb-6 inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 text-sm font-medium text-white backdrop-blur-sm">
                    <svg class="h-4 w-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    <span>Nigeria's Premier Real Estate Platform</span>
                </div>

                <!-- Main Heading -->
                <h1 class="mx-auto max-w-4xl text-5xl font-bold leading-tight text-white sm:text-6xl lg:text-7xl">
                    Discover Your
                    <span class="relative whitespace-nowrap text-transparent">
                        <span class="relative bg-gradient-to-r from-yellow-400 via-orange-400 to-pink-400 bg-clip-text text-transparent">Dream Property</span>
                        <svg class="absolute -bottom-2 left-0 h-3 w-full" viewBox="0 0 300 10" preserveAspectRatio="none">
                            <path d="M0,5 Q150,10 300,5" stroke="url(#gradient)" stroke-width="3" fill="none" stroke-dasharray="8 8"/>
                            <defs>
                                <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" stop-color="#FBBF24" />
                                    <stop offset="50%" stop-color="#FB923C" />
                                    <stop offset="100%" stop-color="#F472B6" />
                                </linearGradient>
                            </defs>
                        </svg>
                    </span>
                    <br />in Nigeria Today
                </h1>

                <!-- Description -->
                <p class="mx-auto mt-6 max-w-2xl text-lg text-gray-300 backdrop-blur-sm">
                    Explore thousands of verified properties from trusted agents across the country. 
                    Your perfect home, office, or investment opportunity awaits.
                </p>

                <!-- Search and CTA Buttons -->
                <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
                    <a href="{{ route('properties.index') }}" 
                       class="group relative inline-flex items-center gap-3 overflow-hidden rounded-2xl bg-gradient-to-r from-orange-500 via-red-500 to-pink-500 px-8 py-4 text-lg font-semibold text-white shadow-2xl transition-all hover:scale-105 hover:shadow-orange-500/30">
                        <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-shimmer"></span>
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Browse All Properties
                    </a>
                    
                    <a href="{{ route('properties.index', ['listing_type' => 'sale']) }}" 
                       class="group inline-flex items-center gap-2 rounded-2xl border-2 border-white/30 bg-white/10 px-8 py-4 text-lg font-semibold text-white backdrop-blur-sm transition-all hover:border-white/50 hover:bg-white/20">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        For Sale
                        <span class="rounded-full bg-white/20 px-2 py-0.5 text-xs">{{ number_format($properties->where('listing_type', 'sale')->count()) }}</span>
                    </a>
                    
                    <a href="{{ route('properties.index', ['listing_type' => 'rent']) }}" 
                       class="group inline-flex items-center gap-2 rounded-2xl border-2 border-white/30 bg-white/10 px-8 py-4 text-lg font-semibold text-white backdrop-blur-sm transition-all hover:border-white/50 hover:bg-white/20">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        For Rent
                        <span class="rounded-full bg-white/20 px-2 py-0.5 text-xs">{{ number_format($properties->where('listing_type', 'rent')->count()) }}</span>
                    </a>
                </div>

                <!-- Trust Indicators -->
                <div class="mt-16 flex flex-wrap items-center justify-center gap-8">
                    <div class="flex items-center gap-2">
                        <div class="flex -space-x-2">
                            <img src="https://randomuser.me/api/portraits/men/1.jpg" class="h-8 w-8 rounded-full border-2 border-white" alt="User">
                            <img src="https://randomuser.me/api/portraits/women/2.jpg" class="h-8 w-8 rounded-full border-2 border-white" alt="User">
                            <img src="https://randomuser.me/api/portraits/men/3.jpg" class="h-8 w-8 rounded-full border-2 border-white" alt="User">
                        </div>
                        <span class="text-sm text-gray-300">10k+ Happy Clients</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <span class="text-sm text-gray-300">4.9/5 Rating</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm text-gray-300">100% Verified Agents</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Curved Bottom Divider -->
        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none">
            <svg class="relative block h-16 w-full" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" 
                      class="fill-white dark:fill-zinc-900" opacity="1"></path>
            </svg>
        </div>
    </div>

    <!-- Stats Section with Modern Design -->
    <div class="relative -mt-16 z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <div class="group relative overflow-hidden rounded-2xl bg-white p-8 shadow-2xl transition-all hover:scale-105 dark:bg-zinc-900">
                <div class="absolute right-0 top-0 h-24 w-24 translate-x-8 -translate-y-8 rounded-full bg-blue-100 opacity-50 blur-2xl transition group-hover:scale-150 dark:bg-blue-900/30"></div>
                <div class="relative">
                    <div class="flex items-center gap-4">
                        <div class="rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 p-3 text-white shadow-lg">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM14 11a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 110-2h1v-1a1 1 0 011-1z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Active Listings</p>
                            <p class="text-3xl font-bold text-zinc-900 dark:text-white">{{ number_format($properties->count()) }}+</p>
                        </div>
                    </div>
                    <div class="mt-2 h-1 w-0 bg-gradient-to-r from-blue-500 to-blue-600 transition-all group-hover:w-full"></div>
                </div>
            </div>

            <div class="group relative overflow-hidden rounded-2xl bg-white p-8 shadow-2xl transition-all hover:scale-105 dark:bg-zinc-900">
                <div class="absolute right-0 top-0 h-24 w-24 translate-x-8 -translate-y-8 rounded-full bg-green-100 opacity-50 blur-2xl transition group-hover:scale-150 dark:bg-green-900/30"></div>
                <div class="relative">
                    <div class="flex items-center gap-4">
                        <div class="rounded-xl bg-gradient-to-br from-green-500 to-green-600 p-3 text-white shadow-lg">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Verified Agents</p>
                            <p class="text-3xl font-bold text-zinc-900 dark:text-white">100%</p>
                        </div>
                    </div>
                    <div class="mt-2 h-1 w-0 bg-gradient-to-r from-green-500 to-green-600 transition-all group-hover:w-full"></div>
                </div>
            </div>

            <div class="group relative overflow-hidden rounded-2xl bg-white p-8 shadow-2xl transition-all hover:scale-105 dark:bg-zinc-900">
                <div class="absolute right-0 top-0 h-24 w-24 translate-x-8 -translate-y-8 rounded-full bg-purple-100 opacity-50 blur-2xl transition group-hover:scale-150 dark:bg-purple-900/30"></div>
                <div class="relative">
                    <div class="flex items-center gap-4">
                        <div class="rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 p-3 text-white shadow-lg">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Happy Clients</p>
                            <p class="text-3xl font-bold text-zinc-900 dark:text-white">10k+</p>
                        </div>
                    </div>
                    <div class="mt-2 h-1 w-0 bg-gradient-to-r from-purple-500 to-purple-600 transition-all group-hover:w-full"></div>
                </div>
            </div>

            <div class="group relative overflow-hidden rounded-2xl bg-white p-8 shadow-2xl transition-all hover:scale-105 dark:bg-zinc-900">
                <div class="absolute right-0 top-0 h-24 w-24 translate-x-8 -translate-y-8 rounded-full bg-orange-100 opacity-50 blur-2xl transition group-hover:scale-150 dark:bg-orange-900/30"></div>
                <div class="relative">
                    <div class="flex items-center gap-4">
                        <div class="rounded-xl bg-gradient-to-br from-orange-500 to-orange-600 p-3 text-white shadow-lg">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 2 2 0 00-2 2v4h-2a2 2 0 00-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Support</p>
                            <p class="text-3xl font-bold text-zinc-900 dark:text-white">24/7</p>
                        </div>
                    </div>
                    <div class="mt-2 h-1 w-0 bg-gradient-to-r from-orange-500 to-orange-600 transition-all group-hover:w-full"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Properties Section -->
    <section class="mt-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="flex flex-col items-center justify-between gap-4 text-center sm:flex-row sm:text-left">
                <div>
                    <h2 class="text-3xl font-bold text-zinc-900 dark:text-white sm:text-4xl">Featured Properties</h2>
                    <p class="mt-2 text-zinc-600 dark:text-zinc-400">Discover our handpicked selection of premium properties</p>
                </div>
                <a href="{{ route('properties.index') }}" 
                       class="group hidden items-center gap-2 rounded-xl bg-black border border-zinc-700 px-6 py-3 font-semibold text-white shadow-lg transition-all hover:shadow-xl hover:shadow-orange-500/20 hover:border-orange-500/50 sm:inline-flex">
                    <span>View All Properties</span>
                    <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            @if($properties->count() > 0)
                <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($properties as $property)
                        <article class="group relative overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-lg transition-all hover:-translate-y-1 hover:shadow-2xl dark:border-zinc-700 dark:bg-zinc-900">
                            <!-- Image Container -->
                            <div class="relative h-56 overflow-hidden">
                                @if($property->primaryImage?->image_path)
                                    <img src="{{ Storage::url($property->primaryImage->image_path) }}" 
                                         alt="{{ $property->title }}" 
                                         class="h-full w-full object-cover transition duration-500 group-hover:scale-110">
                                @else
                                    <div class="flex h-full items-center justify-center bg-gradient-to-br from-zinc-200 to-zinc-300 dark:from-zinc-700 dark:to-zinc-800">
                                        <svg class="h-12 w-12 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif

                                <!-- Badges -->
                                <div class="absolute left-3 top-3 flex gap-2">
                                    <span class="inline-flex items-center gap-1 rounded-xl bg-white/95 px-3 py-1.5 text-xs font-semibold text-zinc-900 shadow-lg backdrop-blur-sm dark:bg-zinc-900/95 dark:text-white">
                                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM14 11a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 110-2h1v-1a1 1 0 011-1z" />
                                        </svg>
                                        {{ ucfirst($property->listing_type) }}
                                    </span>
                                    @if($property->is_featured)
                                        <span class="inline-flex items-center gap-1 rounded-xl bg-amber-500/95 px-3 py-1.5 text-xs font-semibold text-white shadow-lg backdrop-blur-sm">
                                            <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            Featured
                                        </span>
                                    @endif
                                </div>

                                <!-- Price Tag -->
                                <div class="absolute bottom-3 right-3 rounded-xl bg-gradient-to-r from-orange-500 to-red-500 px-4 py-2 text-white shadow-lg">
                                    <p class="text-lg font-bold">₦{{ number_format((float) $property->price) }}</p>
                                    @if($property->price_unit !== 'total')
                                        <p class="text-xs text-orange-100">/{{ $property->price_unit === 'per_month' ? 'month' : 'year' }}</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-4">
                                <h3 class="line-clamp-2 font-semibold text-zinc-900 transition group-hover:text-orange-600 dark:text-white dark:group-hover:text-orange-400">
                                    {{ $property->title }}
                                </h3>

                                <!-- Location -->
                                <div class="mt-2 flex items-center gap-1 text-sm text-zinc-500 dark:text-zinc-400">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>{{ $property->city }}, {{ $property->state }}</span>
                                </div>

                                <!-- Property Features -->
                                <div class="mt-3 flex gap-3 text-xs">
                                    @if($property->bedrooms)
                                        <div class="flex items-center gap-1 text-zinc-600 dark:text-zinc-400">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4a2 2 0 012 2h6a2 2 0 012-2V3m0 0a2 2 0 012 2v4a2 2 0 01-2 2m0 0H9m11 0v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2m6 0v2m0 0a2 2 0 012 2v0m0 0a2 2 0 01-2-2m0 0V3m0 0a2 2 0 00-2 2v4a2 2 0 002 2m0 0H9" />
                                            </svg>
                                            <span>{{ $property->bedrooms }} Beds</span>
                                        </div>
                                    @endif
                                    @if($property->bathrooms)
                                        <div class="flex items-center gap-1 text-zinc-600 dark:text-zinc-400">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6V4m0 0a2 2 0 012-2h3.5A1.5 1.5 0 0112 2.5V4m0 0a2 2 0 012 2v14a2 2 0 01-2 2H8a2 2 0 01-2-2V6zm3 5a1 1 0 11-2 0 1 1 0 012 0z" />
                                            </svg>
                                            <span>{{ $property->bathrooms }} Baths</span>
                                        </div>
                                    @endif
                                    @if($property->area)
                                        <div class="flex items-center gap-1 text-zinc-600 dark:text-zinc-400">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4m0 0h4m-4 0v14m4-14v14" />
                                            </svg>
                                            <span>{{ number_format((float) $property->area) }} {{ $property->area_unit }}</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Agent Info -->
                                <div class="mt-4 flex items-center gap-2">
                                    <div class="h-8 w-8 rounded-full bg-gradient-to-br from-orange-500 to-red-500 p-0.5">
                                        <div class="flex h-full w-full items-center justify-center rounded-full bg-white text-xs font-bold text-orange-600 dark:bg-zinc-900">
                                            {{ substr($property->agent?->user?->name ?? 'A', 0, 1) }}
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-xs font-medium text-zinc-900 dark:text-white">{{ $property->agent?->user?->name ?? 'Agent' }}</p>
                                        <p class="text-xs text-zinc-500">{{ $property->agent?->company_name ?? 'Verified Agent' }}</p>
                                    </div>
                                </div>

                                <!-- View Button -->
                                <a href="{{ route('properties.show', $property->slug) }}" 
                                   class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-orange-500 to-red-500 px-4 py-3 text-sm font-semibold text-white shadow-lg transition-all hover:shadow-xl hover:shadow-orange-500/30">
                                    View Details
                                    <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Mobile View All Button -->
                <div class="mt-10 text-center sm:hidden">
                    <a href="{{ route('properties.index') }}" 
                       class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-orange-500 to-red-500 px-8 py-4 font-semibold text-white shadow-lg transition-all hover:shadow-xl hover:shadow-orange-500/30">
                        View All Properties
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            @else
                <div class="mt-10 rounded-2xl border-2 border-dashed border-zinc-300 bg-zinc-50 p-16 text-center dark:border-zinc-700 dark:bg-zinc-900">
                    <svg class="mx-auto h-16 w-16 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <p class="mt-3 text-xl font-semibold text-zinc-900 dark:text-white">No Properties Available</p>
                    <p class="mt-1 text-zinc-600 dark:text-zinc-400">Properties will appear here as they are approved by our team.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- CTA Section with Modern Design -->
    <section class="mt-20">
        <div class="relative overflow-hidden bg-gradient-to-br from-black via-zinc-900 to-black py-20 dark:from-black dark:via-zinc-950 dark:to-black">
            <!-- Animated Background -->
            <div class="absolute inset-0">
                <div class="absolute left-0 top-0 h-64 w-64 animate-blob rounded-full bg-purple-500/30 mix-blend-multiply blur-3xl"></div>
                <div class="absolute right-0 top-0 h-64 w-64 animate-blob rounded-full bg-yellow-500/30 mix-blend-multiply blur-3xl" style="animation-delay: 2s"></div>
                <div class="absolute bottom-0 left-1/2 h-64 w-64 animate-blob rounded-full bg-pink-500/30 mix-blend-multiply blur-3xl" style="animation-delay: 4s"></div>
                
                <!-- Grid Pattern -->
                <svg class="absolute inset-0 h-full w-full opacity-20">
                    <defs>
                        <pattern id="grid2" width="40" height="40" patternUnits="userSpaceOnUse">
                            <path d="M 40 0 L 0 0 0 40" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/>
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#grid2)" />
                </svg>
            </div>

            <div class="relative mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
                <h2 class="text-4xl font-bold text-white sm:text-5xl">Ready to Get Started?</h2>
                <p class="mt-4 text-xl text-zinc-300">Join thousands of agents and property seekers on Nigeria's fastest growing real estate platform.</p>
                
                <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
                    <a href="{{ route('register') }}" 
                       class="group relative inline-flex items-center gap-3 overflow-hidden rounded-2xl bg-gradient-to-r from-orange-500 via-red-500 to-pink-500 px-8 py-4 text-lg font-semibold text-white shadow-2xl transition-all hover:scale-105 hover:shadow-orange-500/30">
                        <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-shimmer"></span>
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        Create Free Account
                    </a>
                    
                    <a href="{{ route('properties.index') }}" 
                       class="group inline-flex items-center gap-2 rounded-2xl border-2 border-white/30 bg-white/10 px-8 py-4 text-lg font-semibold text-white backdrop-blur-sm transition-all hover:border-orange-500/50 hover:bg-orange-500/10">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Browse Properties
                    </a>
                </div>

                <!-- Trust Badges -->
                <div class="mt-12 flex flex-wrap items-center justify-center gap-8">
                    <div class="flex items-center gap-2 text-gray-300">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>No Credit Card Required</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-300">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM14 11a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 110-2h1v-1a1 1 0 011-1z" />
                        </svg>
                        <span>Verified Agents Only</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-300">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 2 2 0 00-2 2v4h-2a2 2 0 00-2 2z" />
                        </svg>
                        <span>24/7 Customer Support</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes blob {
            0%, 100% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        @keyframes shimmer {
            100% { transform: translateX(100%); }
        }
        .animate-shimmer {
            animation: shimmer 2s infinite;
        }
        .stars {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(2px 2px at 10px 10px, white, rgba(0,0,0,0)),
                              radial-gradient(2px 2px at 20px 30px, white, rgba(0,0,0,0)),
                              radial-gradient(2px 2px at 40px 70px, white, rgba(0,0,0,0)),
                              radial-gradient(2px 2px at 70px 100px, white, rgba(0,0,0,0)),
                              radial-gradient(2px 2px at 120px 140px, white, rgba(0,0,0,0));
            background-size: 200px 200px;
            animation: stars 4s linear infinite;
            opacity: 0.3;
        }
        @keyframes stars {
            from { transform: translateY(0px); }
            to { transform: translateY(-200px); }
        }
    </style>
</x-layouts.guest>