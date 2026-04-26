<x-layouts.user :title="__('My Inquiries')">
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-black to-red-500 p-6 text-white shadow-lg dark:from-red-700 dark:to-red-600">
            <!-- Decorative Elements -->
            <div class="absolute right-0 top-0 h-32 w-32 translate-x-8 -translate-y-8 rounded-full bg-white/20 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 h-32 w-32 -translate-x-8 translate-y-8 rounded-full bg-black/10 blur-3xl"></div>
            
            <div class="relative">
                <div class="flex items-center gap-2">
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
                        <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z" />
                    </svg>
                    <h1 class="text-2xl font-semibold">My Inquiries</h1>
                </div>
                <p class="mt-2 text-sm text-red-100">
                    Track all your property inquiries and their status in one place.
                </p>
            </div>
        </div>

        <!-- Inquiries Table Component -->
        <livewire:user.inquiries-table />
    </div>
</x-layouts.user>