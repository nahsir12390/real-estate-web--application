<x-layouts::app :title="__('Manage Plans')">
    <div class="p-6 space-y-6">
        <!-- Navigation Button -->
        <div class="flex justify-end">
            <a href="{{ route('admin.dashboard') }}"
               class="inline-flex items-center gap-2 rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-300 dark:hover:bg-zinc-800">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Dashboard
            </a>
        </div>

        @include('admin.partials.nav')

        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">Manage Subscription Plans</h1>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Create and manage agent subscription plans</p>
            </div>
            <span class="rounded-full bg-blue-100 px-3 py-1 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                Total: {{ $plans->total() }}
            </span>
        </div>

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

        <!-- Create Plan Form -->
        <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            <h2 class="mb-4 text-lg font-semibold text-zinc-900 dark:text-white">Create New Plan</h2>
            <form method="POST" action="{{ route('admin.plans.store') }}" class="grid gap-4 md:grid-cols-3">
                @csrf
                
                <!-- Basic Info -->
                <div class="md:col-span-3 grid gap-4 md:grid-cols-3">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Plan Name</label>
                        <input name="name" placeholder="e.g., Basic Plan" required 
                               class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Slug</label>
                        <input name="slug" placeholder="e.g., basic-plan" required 
                               class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Duration (days)</label>
                        <input name="duration_days" type="number" min="1" value="30" required 
                               class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    </div>
                </div>

                <!-- Pricing -->
                <div>
                    <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Monthly Price (₦)</label>
                    <input name="price_monthly" type="number" step="0.01" placeholder="0.00" required 
                           class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Yearly Price (₦)</label>
                    <input name="price_yearly" type="number" step="0.01" placeholder="0.00" 
                           class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Listing Limit</label>
                    <input name="listing_limit" type="number" min="0" placeholder="e.g., 10" required 
                           class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                </div>

                <!-- Description -->
                <div class="md:col-span-3">
                    <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Description</label>
                    <textarea name="description" rows="2" placeholder="Brief description of the plan..."
                              class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"></textarea>
                </div>

                <!-- Features -->
                <div class="md:col-span-3">
                    <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Features</label>
                    <textarea name="features" rows="3" 
                              placeholder="Enter features (one per line or comma-separated)&#10;e.g.:&#10;24/7 Support&#10;Featured Listings&#10;Priority Verification"
                              class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white"></textarea>
                </div>

                <!-- Options -->
                <div class="md:col-span-3 flex items-center gap-6">
                    <label class="flex items-center gap-2 text-sm text-zinc-700 dark:text-zinc-300">
                        <input type="checkbox" name="is_popular" value="1" class="rounded border-zinc-300">
                        Mark as Popular
                    </label>
                    <label class="flex items-center gap-2 text-sm text-zinc-700 dark:text-zinc-300">
                        <input type="checkbox" name="is_active" value="1" checked class="rounded border-zinc-300">
                        Active
                    </label>
                </div>

                <!-- Submit -->
                <div class="md:col-span-3">
                    <button type="submit" 
                            class="w-full rounded-lg bg-zinc-900 px-6 py-2.5 text-sm font-medium text-white transition hover:bg-zinc-800 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-300">
                        Create Plan
                    </button>
                </div>
            </form>
        </div>

        <!-- Plans List -->
        <div class="space-y-4">
            @forelse($plans as $plan)
                <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
                    <form method="POST" action="{{ route('admin.plans.update', $plan) }}" class="space-y-4">
                        @csrf
                        @method('PATCH')
                        
                        <!-- Plan Header -->
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                @if($plan->is_popular)
                                    <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                        Popular
                                    </span>
                                @endif
                                @if(!$plan->is_active)
                                    <span class="rounded-full bg-zinc-100 px-3 py-1 text-xs font-medium text-zinc-800 dark:bg-zinc-800 dark:text-zinc-400">
                                        Inactive
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Form Fields -->
                        <div class="grid gap-4 md:grid-cols-3">
                            <div>
                                <label class="mb-1 block text-xs text-zinc-500">Name</label>
                                <input name="name" value="{{ $plan->name }}" required 
                                       class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                            </div>
                            <div>
                                <label class="mb-1 block text-xs text-zinc-500">Slug</label>
                                <input name="slug" value="{{ $plan->slug }}" required 
                                       class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                            </div>
                            <div>
                                <label class="mb-1 block text-xs text-zinc-500">Duration (days)</label>
                                <input name="duration_days" type="number" value="{{ $plan->duration_days }}" required 
                                       class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                            </div>
                            <div>
                                <label class="mb-1 block text-xs text-zinc-500">Monthly Price</label>
                                <input name="price_monthly" type="number" step="0.01" value="{{ $plan->price_monthly }}" required 
                                       class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                            </div>
                            <div>
                                <label class="mb-1 block text-xs text-zinc-500">Yearly Price</label>
                                <input name="price_yearly" type="number" step="0.01" value="{{ $plan->price_yearly }}" 
                                       class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                            </div>
                            <div>
                                <label class="mb-1 block text-xs text-zinc-500">Listing Limit</label>
                                <input name="listing_limit" type="number" value="{{ $plan->listing_limit }}" required 
                                       class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                            </div>
                        </div>

                        <div>
                            <label class="mb-1 block text-xs text-zinc-500">Description</label>
                            <textarea name="description" rows="2" 
                                      class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">{{ $plan->description }}</textarea>
                        </div>

                        <div>
                            <label class="mb-1 block text-xs text-zinc-500">Features</label>
                            <textarea name="features" rows="3" 
                                      class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">{{ is_array($plan->features) ? implode("\n", $plan->features) : '' }}</textarea>
                        </div>

                        <div class="flex items-center gap-6">
                            <label class="flex items-center gap-2 text-sm text-zinc-700 dark:text-zinc-300">
                                <input type="checkbox" name="is_popular" value="1" @checked($plan->is_popular) class="rounded border-zinc-300">
                                Popular
                            </label>
                            <label class="flex items-center gap-2 text-sm text-zinc-700 dark:text-zinc-300">
                                <input type="checkbox" name="is_active" value="1" @checked($plan->is_active) class="rounded border-zinc-300">
                                Active
                            </label>
                        </div>

                        <div class="flex justify-end gap-2 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                            <button type="submit" 
                                    class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                                Update Plan
                            </button>
                            <form method="POST" action="{{ route('admin.plans.delete', $plan) }}" 
                                  onsubmit="return confirm('Are you sure you want to delete this plan?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-red-700">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </form>
                </div>
            @empty
                <div class="rounded-xl border border-zinc-200 bg-white p-12 text-center dark:border-zinc-700 dark:bg-zinc-900">
                    <svg class="mx-auto h-12 w-12 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-zinc-900 dark:text-white">No Plans Found</h3>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Create your first subscription plan above.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $plans->links() }}
        </div>
    </div>
</x-layouts::app>