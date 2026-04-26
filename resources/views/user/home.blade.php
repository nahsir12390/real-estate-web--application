<x-layouts.user :title="__('User Home')">
    <div class="space-y-8">
        <!-- Hero/Welcome Section - Modern Black & White -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-zinc-900 to-zinc-800 p-8 text-white shadow-2xl dark:from-black dark:to-zinc-900 sm:p-10">
            <!-- Animated Background Elements -->
            <div class="absolute inset-0 overflow-hidden">
                <!-- Subtle Gradient Orbs -->
                <div class="absolute -top-40 -right-40 h-80 w-80 animate-pulse rounded-full bg-white/5 blur-3xl"></div>
                <div class="absolute -bottom-40 -left-40 h-80 w-80 animate-pulse rounded-full bg-white/5 blur-3xl" style="animation-delay: 1s"></div>
                
                <!-- Floating Geometric Shapes -->
                <div class="absolute left-10 top-10 h-16 w-16 animate-float rounded-full border border-white/10 bg-white/5"></div>
                <div class="absolute right-10 bottom-10 h-24 w-24 animate-float rounded-lg border border-white/10 bg-white/5" style="animation-delay: 2s;"></div>
                <div class="absolute left-1/4 top-20 h-12 w-12 animate-float border border-white/10 bg-white/5" style="animation-delay: 1.5s; transform: rotate(45deg);"></div>
                
                <!-- Grid Pattern -->
                <svg class="absolute inset-0 h-full w-full opacity-10">
                    <defs>
                        <pattern id="grid-pattern-user" width="40" height="40" patternUnits="userSpaceOnUse">
                            <path d="M 40 0 L 0 0 0 40" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/>
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#grid-pattern-user)" />
                </svg>
                
                <!-- Subtle Stars -->
                <div class="stars"></div>
            </div>

            <!-- Content -->
            <div class="relative z-10">
                <!-- Badge -->
                <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2 text-sm font-medium text-white backdrop-blur-sm">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                    </svg>
                    <span>User Dashboard</span>
                </div>

                <!-- Welcome Text -->
                <h1 class="text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">
                    Welcome back,
                    <span class="relative whitespace-nowrap">
                        <span class="text-white">{{ auth()->user()->name }}!</span>
                        <svg class="absolute -bottom-2 left-0 h-3 w-full" viewBox="0 0 300 10" preserveAspectRatio="none">
                            <path d="M0,5 Q150,10 300,5" stroke="rgba(255,255,255,0.3)" stroke-width="3" fill="none" stroke-dasharray="8 8"/>
                        </svg>
                    </span>
                </h1>

                <p class="mt-4 max-w-2xl text-lg text-zinc-300">
                    Manage your saved properties, track inquiries, and keep your account activity organized all in one place.
                </p>

                <!-- Quick Stats Row -->
                <div class="mt-8 flex flex-wrap gap-4">
                    <div class="flex items-center gap-2 rounded-2xl border border-white/20 bg-white/10 px-5 py-3 backdrop-blur-sm transition-all hover:bg-white/20">
                        <svg class="h-5 w-5 text-zinc-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm font-medium text-white">Saved Properties</span>
                    </div>
                    <div class="flex items-center gap-2 rounded-2xl border border-white/20 bg-white/10 px-5 py-3 backdrop-blur-sm transition-all hover:bg-white/20">
                        <svg class="h-5 w-5 text-zinc-300" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
                            <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z" />
                        </svg>
                        <span class="text-sm font-medium text-white">Active Inquiries</span>
                    </div>
                    <div class="flex items-center gap-2 rounded-2xl border border-white/20 bg-white/10 px-5 py-3 backdrop-blur-sm transition-all hover:bg-white/20">
                        <svg class="h-5 w-5 text-zinc-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm font-medium text-white">Pending Reports</span>
                    </div>
                </div>
            </div>

            <!-- Decorative Wave -->
            <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none">
                <svg class="relative block h-8 w-full" viewBox="0 0 1200 120" preserveAspectRatio="none">
                    <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" 
                          class="fill-white dark:fill-zinc-950" opacity="1"></path>
                </svg>
            </div>
        </div>

        <!-- Profile Information Section - Modern Black & White -->
        @php
            $profile = auth()->user()->profile ?? null;
            $completionFields = collect([
                auth()->user()->name ? 1 : 0,
                $profile?->phone ? 1 : 0,
                $profile?->address ? 1 : 0,
                $profile?->bio ? 1 : 0,
                $profile?->avatar ? 1 : 0,
            ])->sum();
            $totalFields = 5;
            $profileCompleted = round(($completionFields / $totalFields) * 100);
        @endphp
        
        <div class="group relative overflow-hidden rounded-2xl border border-zinc-200 bg-white p-6 shadow-lg transition-all hover:shadow-xl dark:border-zinc-700 dark:bg-zinc-900">
            <!-- Subtle Background Gradient -->
            <div class="absolute right-0 top-0 h-40 w-40 translate-x-8 -translate-y-8 rounded-full bg-gradient-to-br from-zinc-200 to-zinc-300 opacity-50 blur-2xl transition group-hover:scale-150 dark:from-zinc-800 dark:to-zinc-700"></div>
            
            <div class="relative">
                <!-- Header with Edit Button -->
                <div class="flex items-center justify-between">
                    <h3 class="flex items-center gap-2 text-xl font-bold text-zinc-900 dark:text-white">
                        <svg class="h-6 w-6 text-zinc-700 dark:text-zinc-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        Your Profile
                    </h3>
                    <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-1 rounded-lg border border-zinc-300 bg-white px-3 py-1.5 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        Edit Profile
                    </a>
                </div>

                <!-- Profile Completion Bar -->
                <div class="mt-4">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-zinc-600 dark:text-zinc-400">Profile Completion</span>
                        <span class="font-bold text-zinc-900 dark:text-white">{{ $profileCompleted }}%</span>
                    </div>
                    <div class="mt-1 h-2 w-full overflow-hidden rounded-full bg-zinc-200 dark:bg-zinc-700">
                        <div class="h-full rounded-full bg-gradient-to-r from-zinc-600 to-zinc-800 transition-all duration-500 dark:from-zinc-500 dark:to-zinc-300" style="width: {{ $profileCompleted }}%"></div>
                    </div>
                </div>

                <!-- Profile Content Grid -->
                <div class="mt-6 grid gap-6 lg:grid-cols-3">
                    <!-- Left Column - Avatar & Basic Info -->
                    <div class="lg:col-span-1">
                        <div class="flex flex-col items-center text-center lg:items-start lg:text-left">
                            <!-- Avatar -->
                            <div class="relative">
                                @if($profile?->avatar)
                                    <img src="{{ Storage::url($profile->avatar) }}" alt="{{ auth()->user()->name }}" class="h-24 w-24 rounded-2xl object-cover border-2 border-zinc-300 shadow-lg dark:border-zinc-600">
                                @else
                                    <div class="flex h-24 w-24 items-center justify-center rounded-2xl bg-gradient-to-br from-zinc-700 to-zinc-900 text-3xl font-bold text-white shadow-lg">
                                        {{ substr(auth()->user()->name, 0, 2) }}
                                    </div>
                                @endif
                                <div class="absolute -bottom-2 -right-2 rounded-full bg-green-500 p-1.5">
                                    <div class="h-2 w-2 rounded-full bg-white"></div>
                                </div>
                            </div>

                            <!-- Name & Email -->
                            <div class="mt-4">
                                <h4 class="text-lg font-bold text-zinc-900 dark:text-white">{{ auth()->user()->name }}</h4>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ auth()->user()->email }}</p>
                                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-500">Member since {{ auth()->user()->created_at->format('M Y') }}</p>
                            </div>

                            <!-- Bio -->
                            @if($profile?->bio)
                                <div class="mt-3">
                                    <p class="text-sm italic text-zinc-700 dark:text-zinc-300">"{{ $profile->bio }}"</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Middle Column - Contact Information -->
                    <div class="lg:col-span-1">
                        <h4 class="mb-3 text-sm font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Contact Information</h4>
                        <div class="space-y-3">
                            <!-- Phone -->
                            <div class="flex items-start gap-3">
                                <div class="rounded-lg bg-zinc-100 p-2 dark:bg-zinc-800">
                                    <svg class="h-4 w-4 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Phone</p>
                                    @if($profile?->phone)
                                        <a href="tel:{{ $profile->phone }}" class="text-sm font-medium text-zinc-900 hover:text-zinc-700 dark:text-white dark:hover:text-zinc-300">{{ $profile->phone }}</a>
                                    @else
                                        <p class="text-sm text-zinc-500 dark:text-zinc-500">Not added</p>
                                    @endif
                                </div>
                            </div>

                            <!-- WhatsApp -->
                            <div class="flex items-start gap-3">
                                <div class="rounded-lg bg-zinc-100 p-2 dark:bg-zinc-800">
                                    <svg class="h-4 w-4 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">WhatsApp</p>
                                    @if($profile?->whatsapp_number)
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profile->whatsapp_number) }}" target="_blank" rel="noopener" class="text-sm font-medium text-zinc-900 hover:text-zinc-700 dark:text-white dark:hover:text-zinc-300">{{ $profile->whatsapp_number }}</a>
                                    @else
                                        <p class="text-sm text-zinc-500 dark:text-zinc-500">Not added</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="flex items-start gap-3">
                                <div class="rounded-lg bg-zinc-100 p-2 dark:bg-zinc-800">
                                    <svg class="h-4 w-4 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Address</p>
                                    @if($profile?->address)
                                        <p class="text-sm font-medium text-zinc-900 dark:text-white">{{ $profile->address }}</p>
                                    @else
                                        <p class="text-sm text-zinc-500 dark:text-zinc-500">Not added</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Social & Stats -->
                    <div class="lg:col-span-1">
                        <!-- Social Links -->
                        <div>
                            <h4 class="mb-3 text-sm font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Connect</h4>
                            @if($profile?->facebook_url || $profile?->twitter_url || $profile?->instagram_url)
                                <div class="flex gap-2">
                                    @if($profile?->facebook_url)
                                        <a href="{{ $profile->facebook_url }}" target="_blank" rel="noopener" class="rounded-lg bg-zinc-100 p-2 text-zinc-700 transition hover:bg-zinc-200 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700">
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" />
                                            </svg>
                                        </a>
                                    @endif
                                    @if($profile?->twitter_url)
                                        <a href="{{ $profile->twitter_url }}" target="_blank" rel="noopener" class="rounded-lg bg-zinc-100 p-2 text-zinc-700 transition hover:bg-zinc-200 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700">
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                            </svg>
                                        </a>
                                    @endif
                                    @if($profile?->instagram_url)
                                        <a href="{{ $profile->instagram_url }}" target="_blank" rel="noopener" class="rounded-lg bg-zinc-100 p-2 text-zinc-700 transition hover:bg-zinc-200 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700">
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0z" />
                                                <path d="M12 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            @else
                                <p class="text-sm text-zinc-500 dark:text-zinc-500">No social links added</p>
                            @endif
                        </div>

                        <!-- Quick Stats -->
                        <div class="mt-6">
                            <h4 class="mb-3 text-sm font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Account Stats</h4>
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-zinc-600 dark:text-zinc-400">Email Verified</span>
                                    <span class="font-medium {{ auth()->user()->email_verified_at ? 'text-green-600' : 'text-zinc-500' }} dark:{{ auth()->user()->email_verified_at ? 'text-green-400' : 'text-zinc-400' }}">
                                        {{ auth()->user()->email_verified_at ? 'Yes' : 'No' }}
                                    </span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-zinc-600 dark:text-zinc-400">Last Login</span>
                                    <span class="font-medium text-zinc-900 dark:text-white">{{ auth()->user()->last_login_at ? auth()->user()->last_login_at->diffForHumans() : 'First time' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Complete Profile CTA -->
                        @if($profileCompleted < 100)
                            <div class="mt-6 rounded-lg bg-zinc-50 p-4 dark:bg-zinc-800">
                                <p class="text-sm text-zinc-700 dark:text-zinc-300">
                                    <span class="font-bold">Complete your profile</span> to get personalized property recommendations and better visibility.
                                </p>
                                <a href="{{ route('profile.edit') }}" class="mt-3 inline-block w-full rounded-lg bg-zinc-900 py-2 text-center text-sm font-medium text-white transition hover:bg-zinc-800 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-300">
                                    Complete Now
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions - Modern Cards -->
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Saved Properties Card -->
            <a href="{{ route('user.favorites') }}" 
               class="group relative overflow-hidden rounded-2xl border border-zinc-200 bg-white p-6 shadow-lg transition-all hover:-translate-y-1 hover:shadow-xl dark:border-zinc-700 dark:bg-zinc-900">
                <!-- Background Gradient -->
                <div class="absolute right-0 top-0 h-32 w-32 translate-x-8 -translate-y-8 rounded-full bg-gradient-to-br from-zinc-300 to-zinc-400 opacity-30 blur-2xl transition group-hover:scale-150 dark:from-zinc-700 dark:to-zinc-600"></div>
                
                <div class="relative">
                    <!-- Icon -->
                    <div class="relative mb-4 inline-block">
                        <div class="absolute inset-0 rounded-xl bg-zinc-200 blur-lg opacity-50 dark:bg-zinc-700"></div>
                        <div class="relative flex h-14 w-14 items-center justify-center rounded-xl bg-zinc-800 text-white shadow-lg dark:bg-zinc-100 dark:text-zinc-900">
                            <svg class="h-7 w-7" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    
                    <h3 class="text-xl font-bold text-zinc-900 dark:text-white">Saved Properties</h3>
                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">View and manage your favorite listings</p>
                    
                    <!-- Arrow Indicator -->
                    <div class="mt-4 flex items-center gap-1 text-sm font-medium text-zinc-700 dark:text-zinc-300">
                        <span>View all</span>
                        <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>
            </a>

            <!-- My Inquiries Card -->
            <a href="{{ route('user.inquiries') }}" 
               class="group relative overflow-hidden rounded-2xl border border-zinc-200 bg-white p-6 shadow-lg transition-all hover:-translate-y-1 hover:shadow-xl dark:border-zinc-700 dark:bg-zinc-900">
                <div class="absolute right-0 top-0 h-32 w-32 translate-x-8 -translate-y-8 rounded-full bg-gradient-to-br from-zinc-300 to-zinc-400 opacity-30 blur-2xl transition group-hover:scale-150 dark:from-zinc-700 dark:to-zinc-600"></div>
                
                <div class="relative">
                    <div class="relative mb-4 inline-block">
                        <div class="absolute inset-0 rounded-xl bg-zinc-200 blur-lg opacity-50 dark:bg-zinc-700"></div>
                        <div class="relative flex h-14 w-14 items-center justify-center rounded-xl bg-zinc-800 text-white shadow-lg dark:bg-zinc-100 dark:text-zinc-900">
                            <svg class="h-7 w-7" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
                                <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z" />
                            </svg>
                        </div>
                    </div>
                    
                    <h3 class="text-xl font-bold text-zinc-900 dark:text-white">My Inquiries</h3>
                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">Track your conversations with agents</p>
                    
                    <div class="mt-4 flex items-center gap-1 text-sm font-medium text-zinc-700 dark:text-zinc-300">
                        <span>View all</span>
                        <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>
            </a>

            <!-- My Reports Card -->
            <a href="{{ route('user.reports') }}" 
               class="group relative overflow-hidden rounded-2xl border border-zinc-200 bg-white p-6 shadow-lg transition-all hover:-translate-y-1 hover:shadow-xl dark:border-zinc-700 dark:bg-zinc-900">
                <div class="absolute right-0 top-0 h-32 w-32 translate-x-8 -translate-y-8 rounded-full bg-gradient-to-br from-zinc-300 to-zinc-400 opacity-30 blur-2xl transition group-hover:scale-150 dark:from-zinc-700 dark:to-zinc-600"></div>
                
                <div class="relative">
                    <div class="relative mb-4 inline-block">
                        <div class="absolute inset-0 rounded-xl bg-zinc-200 blur-lg opacity-50 dark:bg-zinc-700"></div>
                        <div class="relative flex h-14 w-14 items-center justify-center rounded-xl bg-zinc-800 text-white shadow-lg dark:bg-zinc-100 dark:text-zinc-900">
                            <svg class="h-7 w-7" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    
                    <h3 class="text-xl font-bold text-zinc-900 dark:text-white">My Reports</h3>
                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">View and manage your reports</p>
                    
                    <div class="mt-4 flex items-center gap-1 text-sm font-medium text-zinc-700 dark:text-zinc-300">
                        <span>View all</span>
                        <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Profile Settings Card -->
            <a href="{{ route('profile.edit') }}" 
               class="group relative overflow-hidden rounded-2xl border border-zinc-200 bg-white p-6 shadow-lg transition-all hover:-translate-y-1 hover:shadow-xl dark:border-zinc-700 dark:bg-zinc-900">
                <div class="absolute right-0 top-0 h-32 w-32 translate-x-8 -translate-y-8 rounded-full bg-gradient-to-br from-zinc-300 to-zinc-400 opacity-30 blur-2xl transition group-hover:scale-150 dark:from-zinc-700 dark:to-zinc-600"></div>
                
                <div class="relative">
                    <div class="relative mb-4 inline-block">
                        <div class="absolute inset-0 rounded-xl bg-zinc-200 blur-lg opacity-50 dark:bg-zinc-700"></div>
                        <div class="relative flex h-14 w-14 items-center justify-center rounded-xl bg-zinc-800 text-white shadow-lg dark:bg-zinc-100 dark:text-zinc-900">
                            <svg class="h-7 w-7" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    
                    <h3 class="text-xl font-bold text-zinc-900 dark:text-white">Profile Settings</h3>
                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">Update your personal information</p>
                    
                    <div class="mt-4 flex items-center gap-1 text-sm font-medium text-zinc-700 dark:text-zinc-300">
                        <span>View all</span>
                        <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>
            </a>
        </div>

        <!-- Main Dashboard Content -->
        <div class="relative">
            <livewire:user.dashboard-overview />
        </div>
    </div>

    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        .stars {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(2px 2px at 10px 10px, rgba(255,255,255,0.3), rgba(0,0,0,0)),
                              radial-gradient(2px 2px at 20px 30px, rgba(255,255,255,0.3), rgba(0,0,0,0)),
                              radial-gradient(2px 2px at 40px 70px, rgba(255,255,255,0.3), rgba(0,0,0,0)),
                              radial-gradient(2px 2px at 70px 100px, rgba(255,255,255,0.3), rgba(0,0,0,0)),
                              radial-gradient(2px 2px at 120px 140px, rgba(255,255,255,0.3), rgba(0,0,0,0));
            background-size: 200px 200px;
            animation: stars 4s linear infinite;
            opacity: 0.2;
        }
        @keyframes stars {
            from { transform: translateY(0px); }
            to { transform: translateY(-200px); }
        }
    </style>
</x-layouts.user>