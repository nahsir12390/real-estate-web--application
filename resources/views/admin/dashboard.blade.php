<x-layouts::app :title="__('Admin Dashboard')">
    <div class="space-y-6 p-6">
        <!-- Navigation Button -->
        <div class="flex justify-end">
            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center rounded-md bg-zinc-900 px-3 py-1.5 text-sm font-medium text-white hover:bg-zinc-700 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-300">
                <svg class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </a>
        </div>

        @include('admin.partials.nav')

        @if (session('status'))
            <div class="rounded-lg border border-green-300 bg-green-50 p-4 text-sm text-green-700 dark:border-green-800 dark:bg-green-900/30 dark:text-green-400">
                <div class="flex items-center gap-2">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            </div>
        @endif

        <!-- Hero Section -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-zinc-900 to-zinc-800 p-8 text-white shadow-xl dark:from-zinc-950 dark:to-zinc-900">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <defs>
                        <pattern id="grid" width="8" height="8" patternUnits="userSpaceOnUse">
                            <path d="M 8 0 L 0 0 0 8" fill="none" stroke="white" stroke-width="0.5"/>
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#grid)" />
                </svg>
            </div>

            <!-- Decorative Blobs -->
            <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-blue-500/20 blur-3xl"></div>
            <div class="absolute -bottom-20 -left-20 h-64 w-64 rounded-full bg-purple-500/20 blur-3xl"></div>

            <div class="relative z-10">
                <div class="flex items-center gap-2 text-sm font-medium text-blue-300">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM14 11a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 110-2h1v-1a1 1 0 011-1z" />
                    </svg>
                    <span>Control Center</span>
                </div>
                <h1 class="mt-4 text-4xl font-bold tracking-tight">Admin Dashboard</h1>
                <p class="mt-2 max-w-2xl text-zinc-300">
                    Centralized overview for approvals, subscriptions, moderation, and platform operations.
                </p>
                
                <!-- Quick Action Buttons -->
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('admin.agents.index', ['status' => 'pending']) }}" 
                       class="inline-flex items-center gap-2 rounded-lg bg-white/10 px-4 py-2 text-sm font-medium text-white backdrop-blur-sm transition hover:bg-white/20">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Review Agents
                        @if($stats['agents_pending'] > 0)
                            <span class="ml-1 rounded-full bg-red-500 px-2 py-0.5 text-xs">{{ $stats['agents_pending'] }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.properties.index', ['status' => 'pending']) }}" 
                       class="inline-flex items-center gap-2 rounded-lg bg-white/10 px-4 py-2 text-sm font-medium text-white backdrop-blur-sm transition hover:bg-white/20">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Review Properties
                        @if($stats['properties_pending'] > 0)
                            <span class="ml-1 rounded-full bg-red-500 px-2 py-0.5 text-xs">{{ $stats['properties_pending'] }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.reports.index', ['status' => 'pending']) }}" 
                       class="inline-flex items-center gap-2 rounded-lg bg-white/10 px-4 py-2 text-sm font-medium text-white backdrop-blur-sm transition hover:bg-white/20">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        Moderate Reports
                        @if($stats['open_reports'] > 0)
                            <span class="ml-1 rounded-full bg-red-500 px-2 py-0.5 text-xs">{{ $stats['open_reports'] }}</span>
                        @endif
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            <!-- Total Users -->
            <div class="group relative rounded-xl border border-zinc-200 bg-white p-6 transition-all hover:shadow-lg dark:border-zinc-700 dark:bg-zinc-900">
                <div class="absolute right-4 top-4 opacity-10 transition group-hover:scale-110 group-hover:opacity-20">
                    <svg class="h-12 w-12 text-zinc-900 dark:text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                <div class="relative">
                    <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Users</p>
                    <p class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">{{ number_format($stats['users']) }}</p>
                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-500">All registered users across roles</p>
                </div>
                <div class="absolute bottom-0 left-0 h-1 w-0 bg-blue-500 transition-all group-hover:w-full"></div>
            </div>

            <!-- Pending Agents -->
            <div class="group relative rounded-xl border border-zinc-200 bg-white p-6 transition-all hover:shadow-lg dark:border-zinc-700 dark:bg-zinc-900">
                <div class="absolute right-4 top-4 opacity-10 transition group-hover:scale-110 group-hover:opacity-20">
                    <svg class="h-12 w-12 text-yellow-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-1 .05 1.16.84 2 1.87 2 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                    </svg>
                </div>
                <div class="relative">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Pending Agents</p>
                        @if($stats['agents_pending'] > 0)
                            <span class="rounded-full bg-yellow-100 px-2 py-0.5 text-xs font-medium text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                Needs Review
                            </span>
                        @endif
                    </div>
                    <p class="mt-2 text-3xl font-bold {{ $stats['agents_pending'] > 0 ? 'text-yellow-600' : 'text-zinc-900 dark:text-white' }}">
                        {{ number_format($stats['agents_pending']) }}
                    </p>
                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-500">Agent accounts waiting for verification</p>
                </div>
                <div class="absolute bottom-0 left-0 h-1 w-0 bg-yellow-500 transition-all group-hover:w-full"></div>
            </div>

            <!-- Pending Properties -->
            <div class="group relative rounded-xl border border-zinc-200 bg-white p-6 transition-all hover:shadow-lg dark:border-zinc-700 dark:bg-zinc-900">
                <div class="absolute right-4 top-4 opacity-10 transition group-hover:scale-110 group-hover:opacity-20">
                    <svg class="h-12 w-12 text-orange-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 9H5c-1.1 0-2 .9-2 2v8h18v-8c0-1.1-.9-2-2-2zm-7 4c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"/>
                    </svg>
                </div>
                <div class="relative">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Pending Properties</p>
                        @if($stats['properties_pending'] > 0)
                            <span class="rounded-full bg-orange-100 px-2 py-0.5 text-xs font-medium text-orange-800 dark:bg-orange-900/30 dark:text-orange-400">
                                Needs Review
                            </span>
                        @endif
                    </div>
                    <p class="mt-2 text-3xl font-bold {{ $stats['properties_pending'] > 0 ? 'text-orange-600' : 'text-zinc-900 dark:text-white' }}">
                        {{ number_format($stats['properties_pending']) }}
                    </p>
                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-500">Listings waiting for moderation approval</p>
                </div>
                <div class="absolute bottom-0 left-0 h-1 w-0 bg-orange-500 transition-all group-hover:w-full"></div>
            </div>

            <!-- Active Subscriptions -->
            <div class="group relative rounded-xl border border-zinc-200 bg-white p-6 transition-all hover:shadow-lg dark:border-zinc-700 dark:bg-zinc-900">
                <div class="absolute right-4 top-4 opacity-10 transition group-hover:scale-110 group-hover:opacity-20">
                    <svg class="h-12 w-12 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                </div>
                <div class="relative">
                    <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Active Subscriptions</p>
                    <p class="mt-2 text-3xl font-bold text-green-600 dark:text-green-400">{{ number_format($stats['active_subscriptions']) }}</p>
                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-500">Currently paying and valid plans</p>
                </div>
                <div class="absolute bottom-0 left-0 h-1 w-0 bg-green-500 transition-all group-hover:w-full"></div>
            </div>

            <!-- Open Reports -->
            <div class="group relative rounded-xl border border-zinc-200 bg-white p-6 transition-all hover:shadow-lg dark:border-zinc-700 dark:bg-zinc-900">
                <div class="absolute right-4 top-4 opacity-10 transition group-hover:scale-110 group-hover:opacity-20">
                    <svg class="h-12 w-12 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                    </svg>
                </div>
                <div class="relative">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Open Reports</p>
                        @if($stats['open_reports'] > 0)
                            <span class="rounded-full bg-red-100 px-2 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                Needs Attention
                            </span>
                        @endif
                    </div>
                    <p class="mt-2 text-3xl font-bold {{ $stats['open_reports'] > 0 ? 'text-red-600' : 'text-zinc-900 dark:text-white' }}">
                        {{ number_format($stats['open_reports']) }}
                    </p>
                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-500">Safety and quality flags to resolve</p>
                </div>
                <div class="absolute bottom-0 left-0 h-1 w-0 bg-red-500 transition-all group-hover:w-full"></div>
            </div>

            <!-- New Inquiries -->
            <div class="group relative rounded-xl border border-zinc-200 bg-white p-6 transition-all hover:shadow-lg dark:border-zinc-700 dark:bg-zinc-900">
                <div class="absolute right-4 top-4 opacity-10 transition group-hover:scale-110 group-hover:opacity-20">
                    <svg class="h-12 w-12 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h14l4 4V4c0-1.1-.9-2-2-2zm-3 12H7c-.55 0-1-.45-1-1s.45-1 1-1h10c.55 0 1 .45 1 1s-.45 1-1 1zm0-3H7c-.55 0-1-.45-1-1s.45-1 1-1h10c.55 0 1 .45 1 1s-.45 1-1 1zm0-3H7c-.55 0-1-.45-1-1s.45-1 1-1h10c.55 0 1 .45 1 1s-.45 1-1 1z"/>
                    </svg>
                </div>
                <div class="relative">
                    <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">New Inquiries</p>
                    <p class="mt-2 text-3xl font-bold text-blue-600 dark:text-blue-400">{{ number_format($stats['new_inquiries']) }}</p>
                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-500">Buyer/renter messages awaiting follow-up</p>
                </div>
                <div class="absolute bottom-0 left-0 h-1 w-0 bg-blue-500 transition-all group-hover:w-full"></div>
            </div>
        </div>

        <!-- Quick Access Sections -->
        <div class="grid gap-4 md:grid-cols-2">
            <!-- Recent Activity -->
            <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Quick Actions</h2>
                <div class="mt-4 space-y-2">
                    <a href="{{ route('admin.verifications.index', ['status' => 'pending']) }}" 
                       class="flex items-center justify-between rounded-lg border border-zinc-200 p-3 transition hover:bg-zinc-50 dark:border-zinc-700 dark:hover:bg-zinc-800">
                        <div class="flex items-center gap-3">
                            <div class="rounded-full bg-blue-100 p-2 dark:bg-blue-900/30">
                                <svg class="h-4 w-4 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Review Verifications</span>
                        </div>
                        <svg class="h-5 w-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>

                    <a href="{{ route('admin.plans.index') }}" 
                       class="flex items-center justify-between rounded-lg border border-zinc-200 p-3 transition hover:bg-zinc-50 dark:border-zinc-700 dark:hover:bg-zinc-800">
                        <div class="flex items-center gap-3">
                            <div class="rounded-full bg-purple-100 p-2 dark:bg-purple-900/30">
                                <svg class="h-4 w-4 text-purple-600 dark:text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                                    <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Manage Subscription Plans</span>
                        </div>
                        <svg class="h-5 w-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>

                    <a href="{{ route('admin.users.index') }}" 
                       class="flex items-center justify-between rounded-lg border border-zinc-200 p-3 transition hover:bg-zinc-50 dark:border-zinc-700 dark:hover:bg-zinc-800">
                        <div class="flex items-center gap-3">
                            <div class="rounded-full bg-green-100 p-2 dark:bg-green-900/30">
                                <svg class="h-4 w-4 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Manage Users</span>
                        </div>
                        <svg class="h-5 w-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>

                    <a href="{{ route('admin.settings.index') }}" 
                       class="flex items-center justify-between rounded-lg border border-zinc-200 p-3 transition hover:bg-zinc-50 dark:border-zinc-700 dark:hover:bg-zinc-800">
                        <div class="flex items-center gap-3">
                            <div class="rounded-full bg-zinc-100 p-2 dark:bg-zinc-800">
                                <svg class="h-4 w-4 text-zinc-600 dark:text-zinc-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Platform Settings</span>
                        </div>
                        <svg class="h-5 w-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- System Status -->
            <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">System Status</h2>
                <div class="mt-4 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-zinc-600 dark:text-zinc-400">Platform Health</span>
                        <span class="flex items-center gap-1.5">
                            <span class="h-2 w-2 rounded-full bg-green-500"></span>
                            <span class="text-sm font-medium text-green-600 dark:text-green-400">Operational</span>
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-zinc-600 dark:text-zinc-400">Cache Status</span>
                        <span class="text-sm text-zinc-900 dark:text-white">Active</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-zinc-600 dark:text-zinc-400">Last Updated</span>
                        <span class="text-sm text-zinc-900 dark:text-white">{{ now()->format('M d, Y H:i') }}</span>
                    </div>
                    <div class="mt-4 rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800">
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Quick Tip</p>
                        <p class="mt-1 text-sm text-zinc-700 dark:text-zinc-300">
                            Use the filters on each management page to narrow down pending items and process them efficiently.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>