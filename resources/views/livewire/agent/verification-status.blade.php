<div class="space-y-4">
    <!-- Navigation Button -->
    <div class="flex justify-end">
        <a href="{{ route('agent.dashboard') }}"
           class="inline-flex items-center rounded-md bg-zinc-900 px-3 py-1.5 text-sm font-medium text-white hover:bg-zinc-700 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-300">
            <svg class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Dashboard
        </a>
    </div>

    @if (session('status'))
        <div class="rounded-lg border border-green-300 bg-green-50 p-3 text-sm text-green-700 dark:border-green-800 dark:bg-green-900/30 dark:text-green-400">
            {{ session('status') }}
        </div>
    @endif

    <!-- Current Verification Status Card -->
    <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Current Verification Status</h2>
                <div class="mt-2 flex items-center gap-2">
                    @php
                        $statusColors = [
                            'incomplete' => 'bg-zinc-100 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-300',
                            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                            'verified' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                            'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                        ];
                        $currentStatus = $latest ? ($agent?->verification_status ?? 'pending') : 'incomplete';
                        $statusColor = $statusColors[$currentStatus] ?? 'bg-zinc-100 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-400';
                    @endphp
                    <span class="rounded-full px-3 py-1 text-xs font-medium {{ $statusColor }}">
                        {{ ucfirst($currentStatus) }}
                    </span>
                    @if($agent?->verified_at)
                        <span class="text-xs text-zinc-500 dark:text-zinc-400">
                            Verified on {{ $agent->verified_at->format('M d, Y') }}
                        </span>
                    @endif
                </div>
            </div>
            @if($agent?->isVerified())
                <div class="rounded-full bg-green-100 p-2 dark:bg-green-900/30">
                    <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
            @endif
        </div>

        @if($agent?->rejection_reason)
            <div class="mt-4 rounded-lg bg-red-50 p-4 dark:bg-red-900/20">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800 dark:text-red-300">Rejection Reason</h3>
                        <p class="mt-1 text-sm text-red-700 dark:text-red-400">{{ $agent->rejection_reason }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Latest Submission Card -->
    @if($latest)
        <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            <h3 class="mb-3 text-lg font-semibold text-zinc-900 dark:text-white">Latest Submission</h3>
            <div class="grid gap-4 md:grid-cols-2">
                <div class="space-y-2">
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">
                        <span class="font-medium">Status:</span> 
                        <span class="rounded-full bg-yellow-100 px-2 py-0.5 text-xs font-medium text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                            {{ ucfirst($latest->status) }}
                        </span>
                    </p>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">
                        <span class="font-medium">Submitted:</span> 
                        {{ $latest->created_at->format('F j, Y, g:i a') }}
                    </p>
                    @if($latest->reviewed_at)
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">
                            <span class="font-medium">Reviewed:</span> 
                            {{ $latest->reviewed_at->format('F j, Y, g:i a') }}
                        </p>
                    @endif
                </div>
                
                @if($latest->admin_notes)
                    <div class="rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800">
                        <p class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Admin Notes</p>
                        <p class="mt-1 text-sm text-zinc-700 dark:text-zinc-300">{{ $latest->admin_notes }}</p>
                    </div>
                @endif
            </div>

            <!-- Submitted Images Preview -->
            <div class="mt-4">
                <p class="mb-2 text-sm font-medium text-zinc-700 dark:text-zinc-300">Submitted Documents</p>
                <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
                    @if($latest->id_front_image)
                        <div class="group relative">
                            <img src="{{ Storage::url($latest->id_front_image) }}" 
                                 alt="ID Front" 
                                 class="h-24 w-full rounded-lg object-cover ring-1 ring-zinc-200 dark:ring-zinc-700">
                            <span class="absolute bottom-1 left-1 rounded bg-black/50 px-1.5 py-0.5 text-xs text-white">ID Front</span>
                        </div>
                    @endif
                    @if($latest->id_back_image)
                        <div class="group relative">
                            <img src="{{ Storage::url($latest->id_back_image) }}" 
                                 alt="ID Back" 
                                 class="h-24 w-full rounded-lg object-cover ring-1 ring-zinc-200 dark:ring-zinc-700">
                            <span class="absolute bottom-1 left-1 rounded bg-black/50 px-1.5 py-0.5 text-xs text-white">ID Back</span>
                        </div>
                    @endif
                    @if($latest->selfie_image)
                        <div class="group relative">
                            <img src="{{ Storage::url($latest->selfie_image) }}" 
                                 alt="Selfie" 
                                 class="h-24 w-full rounded-lg object-cover ring-1 ring-zinc-200 dark:ring-zinc-700">
                            <span class="absolute bottom-1 left-1 rounded bg-black/50 px-1.5 py-0.5 text-xs text-white">Selfie</span>
                        </div>
                    @endif
                    @if($latest->license_image)
                        <div class="group relative">
                            <img src="{{ Storage::url($latest->license_image) }}" 
                                 alt="License" 
                                 class="h-24 w-full rounded-lg object-cover ring-1 ring-zinc-200 dark:ring-zinc-700">
                            <span class="absolute bottom-1 left-1 rounded bg-black/50 px-1.5 py-0.5 text-xs text-white">License</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Submit Verification Documents Form -->
    @if(!$agent?->isVerified() || $agent?->verification_status === 'rejected')
        <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            <h3 class="mb-4 text-lg font-semibold text-zinc-900 dark:text-white">
                {{ $agent?->verification_status === 'rejected' ? 'Resubmit Verification Documents' : 'Submit Verification Documents' }}
            </h3>
            
            <form wire:submit="submit" class="space-y-6">
                <!-- Image Upload Grid with Previews -->
                <div class="grid gap-6 md:grid-cols-2">
                    <!-- ID Front -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                            ID Front <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="file" 
                                   wire:model="id_front_image" 
                                   accept="image/*" 
                                   class="hidden" 
                                   id="id_front_upload">
                            <label for="id_front_upload" 
                                   class="flex cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-zinc-300 bg-zinc-50 p-4 transition hover:bg-zinc-100 dark:border-zinc-600 dark:bg-zinc-800 dark:hover:bg-zinc-700">
                                <svg class="mb-2 h-8 w-8 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-sm text-zinc-600 dark:text-zinc-400">Click to upload ID front</span>
                                <span class="mt-1 text-xs text-zinc-400">PNG, JPG up to 4MB</span>
                            </label>
                        </div>
                        @if($id_front_image)
                            <div class="relative mt-2">
                                <img src="{{ $id_front_image->temporaryUrl() }}" 
                                     alt="ID Front Preview" 
                                     class="h-32 w-full rounded-lg object-cover ring-2 ring-blue-500">
                                <button type="button" 
                                        wire:click="$set('id_front_image', null)" 
                                        class="absolute right-1 top-1 rounded-full bg-red-500 p-1 text-white hover:bg-red-600">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        @endif
                        @error('id_front_image') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <!-- ID Back -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                            ID Back <span class="text-zinc-400">(Optional)</span>
                        </label>
                        <div class="relative">
                            <input type="file" 
                                   wire:model="id_back_image" 
                                   accept="image/*" 
                                   class="hidden" 
                                   id="id_back_upload">
                            <label for="id_back_upload" 
                                   class="flex cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-zinc-300 bg-zinc-50 p-4 transition hover:bg-zinc-100 dark:border-zinc-600 dark:bg-zinc-800 dark:hover:bg-zinc-700">
                                <svg class="mb-2 h-8 w-8 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-sm text-zinc-600 dark:text-zinc-400">Click to upload ID back</span>
                                <span class="mt-1 text-xs text-zinc-400">PNG, JPG up to 4MB</span>
                            </label>
                        </div>
                        @if($id_back_image)
                            <div class="relative mt-2">
                                <img src="{{ $id_back_image->temporaryUrl() }}" 
                                     alt="ID Back Preview" 
                                     class="h-32 w-full rounded-lg object-cover ring-2 ring-blue-500">
                                <button type="button" 
                                        wire:click="$set('id_back_image', null)" 
                                        class="absolute right-1 top-1 rounded-full bg-red-500 p-1 text-white hover:bg-red-600">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        @endif
                        @error('id_back_image') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <!-- Selfie -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                            Selfie with ID <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="file" 
                                   wire:model="selfie_image" 
                                   accept="image/*" 
                                   class="hidden" 
                                   id="selfie_upload">
                            <label for="selfie_upload" 
                                   class="flex cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-zinc-300 bg-zinc-50 p-4 transition hover:bg-zinc-100 dark:border-zinc-600 dark:bg-zinc-800 dark:hover:bg-zinc-700">
                                <svg class="mb-2 h-8 w-8 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span class="text-sm text-zinc-600 dark:text-zinc-400">Click to upload selfie</span>
                                <span class="mt-1 text-xs text-zinc-400">PNG, JPG up to 4MB</span>
                            </label>
                        </div>
                        @if($selfie_image)
                            <div class="relative mt-2">
                                <img src="{{ $selfie_image->temporaryUrl() }}" 
                                     alt="Selfie Preview" 
                                     class="h-32 w-full rounded-lg object-cover ring-2 ring-blue-500">
                                <button type="button" 
                                        wire:click="$set('selfie_image', null)" 
                                        class="absolute right-1 top-1 rounded-full bg-red-500 p-1 text-white hover:bg-red-600">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        @endif
                        @error('selfie_image') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <!-- License -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                            License <span class="text-zinc-400">(Optional)</span>
                        </label>
                        <div class="relative">
                            <input type="file" 
                                   wire:model="license_image" 
                                   accept="image/*" 
                                   class="hidden" 
                                   id="license_upload">
                            <label for="license_upload" 
                                   class="flex cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-zinc-300 bg-zinc-50 p-4 transition hover:bg-zinc-100 dark:border-zinc-600 dark:bg-zinc-800 dark:hover:bg-zinc-700">
                                <svg class="mb-2 h-8 w-8 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span class="text-sm text-zinc-600 dark:text-zinc-400">Click to upload license</span>
                                <span class="mt-1 text-xs text-zinc-400">PNG, JPG up to 4MB</span>
                            </label>
                        </div>
                        @if($license_image)
                            <div class="relative mt-2">
                                <img src="{{ $license_image->temporaryUrl() }}" 
                                     alt="License Preview" 
                                     class="h-32 w-full rounded-lg object-cover ring-2 ring-blue-500">
                                <button type="button" 
                                        wire:click="$set('license_image', null)" 
                                        class="absolute right-1 top-1 rounded-full bg-red-500 p-1 text-white hover:bg-red-600">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        @endif
                        @error('license_image') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Validation Errors -->
                @error('*')
                    <div class="rounded-lg bg-red-50 p-3 dark:bg-red-900/20">
                        <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    </div>
                @enderror

                <!-- Submit Button -->
                <div class="flex items-center justify-end gap-3">
                    <button type="button" 
                            onclick="window.history.back()" 
                            class="rounded-lg border border-zinc-300 px-4 py-2 text-sm font-medium text-zinc-700 hover:bg-zinc-50 dark:border-zinc-600 dark:text-zinc-300 dark:hover:bg-zinc-800">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 dark:bg-blue-500 dark:hover:bg-blue-600"
                            wire:loading.attr="disabled"
                            wire:target="submit">
                        <span wire:loading.remove wire:target="submit">Submit Verification</span>
                        <span wire:loading wire:target="submit" class="flex items-center gap-2">
                            <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Submitting...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    @endif

    <!-- Verified Message -->
    @if($agent?->isVerified())
        <div class="rounded-xl border border-green-200 bg-green-50 p-6 text-center dark:border-green-800 dark:bg-green-900/20">
            <svg class="mx-auto h-12 w-12 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <h3 class="mt-2 text-lg font-medium text-green-800 dark:text-green-300">Your account is verified!</h3>
            <p class="mt-1 text-sm text-green-700 dark:text-green-400">You can now list properties and manage your listings.</p>
            <div class="mt-4">
                <a href="{{ route('agent.properties.create') }}" 
                   class="inline-flex items-center rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add New Property
                </a>
            </div>
        </div>
    @endif
</div>
