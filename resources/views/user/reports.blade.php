<x-layouts.user :title="__('My Reports')">
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-black to-pink-500 p-6 text-white shadow-lg dark:from-pink-700 dark:to-pink-600">
            <!-- Decorative Elements -->
            <div class="absolute right-0 top-0 h-32 w-32 translate-x-8 -translate-y-8 rounded-full bg-white/20 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 h-32 w-32 -translate-x-8 translate-y-8 rounded-full bg-black/10 blur-3xl"></div>
            
            <div class="relative">
                <div class="flex items-center gap-2">
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <h1 class="text-2xl font-semibold">My Reports</h1>
                </div>
                <p class="mt-2 text-sm text-pink-100">
                    Track and manage all your property reports in one place.
                </p>
            </div>
        </div>

        <!-- Reports Table Component -->
        <livewire:user.reports-table />
    </div>
</x-layouts.user>