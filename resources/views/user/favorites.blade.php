<x-layouts.user :title="__('My Favorites')">
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-black to-red-500 p-6 text-white shadow-lg dark:from-red-700 dark:to-red-600">
            <!-- Decorative Elements -->
            <div class="absolute right-0 top-0 h-32 w-32 translate-x-8 -translate-y-8 rounded-full bg-white/20 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 h-32 w-32 -translate-x-8 translate-y-8 rounded-full bg-black/10 blur-3xl"></div>
            
            <div class="relative">
                <div class="flex items-center gap-2">
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                    </svg>
                    <h1 class="text-2xl font-semibold">My Favorites</h1>
                </div>
                <p class="mt-2 text-sm text-red-100">
                    Keep track of properties you love and revisit them anytime.
                </p>
            </div>
        </div>

        <!-- Favorites Table Component -->
        <livewire:user.favorites-table />
    </div>
</x-layouts.user>