<x-layouts::app :title="__('Agent Verifications')">
    <div class="p-6">
        <!-- Navigation Button -->
        <div class="mb-4 flex justify-end">
            <a href="{{ route('admin.dashboard') }}"
               class="inline-flex items-center rounded-md bg-zinc-900 px-3 py-1.5 text-sm font-medium text-white hover:bg-zinc-700 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-300">
                <svg class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Dashboard
            </a>
        </div>
        @include('admin.partials.nav')
        <h1 class="mb-4 text-2xl font-semibold">Agent Verification Requests</h1>

        @if (session('status'))
            <div class="mb-4 rounded border border-green-300 bg-green-50 p-3 text-sm text-green-700">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="mb-4 rounded border border-red-300 bg-red-50 p-3 text-sm text-red-700">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="GET" class="mb-4 grid gap-2 md:grid-cols-3">
            <input name="search" value="{{ $search }}" placeholder="Search by name or email" class="rounded border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-900">
            <select name="status" class="rounded border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-900">
                <option value="">All statuses</option>
                <option value="pending" @selected($status === 'pending')>Pending</option>
                <option value="approved" @selected($status === 'approved')>Approved</option>
                <option value="rejected" @selected($status === 'rejected')>Rejected</option>
            </select>
            <button class="rounded bg-zinc-900 px-3 py-2 text-white dark:bg-zinc-100 dark:text-zinc-900">Filter</button>
        </form>

        <div class="space-y-4">
            @forelse($verifications as $verification)
                <div class="rounded-xl border border-zinc-200 p-4 dark:border-zinc-700">
                    <div class="mb-3 flex flex-wrap items-start justify-between gap-2">
                        <div>
                            <p class="font-semibold">{{ $verification->agent?->user?->name }}</p>
                            <p class="text-sm text-zinc-500">{{ $verification->agent?->user?->email }}</p>
                        </div>
                        <div class="text-right">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                    'approved' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                    'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                ];
                            @endphp
                            <p class="text-sm"><span class="rounded-full px-2 py-1 text-xs font-semibold {{ $statusColors[$verification->status] ?? 'bg-zinc-100' }}">{{ ucfirst($verification->status) }}</span></p>
                            <p class="mt-1 text-xs text-zinc-500">Submitted: {{ $verification->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>

                    <!-- Image Previews Grid -->
                    <div class="mb-4 grid gap-2 grid-cols-2 md:grid-cols-4">
                        @if($verification->id_front_image)
                            <div class="group relative">
                                <img src="{{ Storage::url($verification->id_front_image) }}" alt="ID Front" class="h-32 w-full rounded-lg border border-zinc-200 object-cover dark:border-zinc-700">
                                <p class="mt-1 text-xs text-zinc-600 dark:text-zinc-400">ID Front</p>
                                <a href="{{ Storage::url($verification->id_front_image) }}" target="_blank" class="absolute inset-0 flex items-center justify-center rounded-lg bg-black/0 text-white opacity-0 transition-all group-hover:bg-black/50 group-hover:opacity-100">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </a>
                            </div>
                        @endif
                        @if($verification->id_back_image)
                            <div class="group relative">
                                <img src="{{ Storage::url($verification->id_back_image) }}" alt="ID Back" class="h-32 w-full rounded-lg border border-zinc-200 object-cover dark:border-zinc-700">
                                <p class="mt-1 text-xs text-zinc-600 dark:text-zinc-400">ID Back</p>
                                <a href="{{ Storage::url($verification->id_back_image) }}" target="_blank" class="absolute inset-0 flex items-center justify-center rounded-lg bg-black/0 text-white opacity-0 transition-all group-hover:bg-black/50 group-hover:opacity-100">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </a>
                            </div>
                        @endif
                        @if($verification->selfie_image)
                            <div class="group relative">
                                <img src="{{ Storage::url($verification->selfie_image) }}" alt="Selfie" class="h-32 w-full rounded-lg border border-zinc-200 object-cover dark:border-zinc-700">
                                <p class="mt-1 text-xs text-zinc-600 dark:text-zinc-400">Selfie</p>
                                <a href="{{ Storage::url($verification->selfie_image) }}" target="_blank" class="absolute inset-0 flex items-center justify-center rounded-lg bg-black/0 text-white opacity-0 transition-all group-hover:bg-black/50 group-hover:opacity-100">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </a>
                            </div>
                        @endif
                        @if($verification->license_image)
                            <div class="group relative">
                                <img src="{{ Storage::url($verification->license_image) }}" alt="License" class="h-32 w-full rounded-lg border border-zinc-200 object-cover dark:border-zinc-700">
                                <p class="mt-1 text-xs text-zinc-600 dark:text-zinc-400">License</p>
                                <a href="{{ Storage::url($verification->license_image) }}" target="_blank" class="absolute inset-0 flex items-center justify-center rounded-lg bg-black/0 text-white opacity-0 transition-all group-hover:bg-black/50 group-hover:opacity-100">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </a>
                            </div>
                        @endif
                    </div>

                    @if($verification->admin_notes)
                        <p class="mb-3 text-sm text-zinc-600 dark:text-zinc-300"><strong>Admin Notes:</strong> {{ $verification->admin_notes }}</p>
                    @endif

                    @if($verification->rejection_reason)
                        <p class="mb-3 text-sm text-red-600 dark:text-red-400"><strong>Rejection Reason:</strong> {{ $verification->rejection_reason }}</p>
                    @endif

                    <!-- Action Forms - Only show for pending verifications -->
                    @if($verification->status === 'pending')
                        <div class="grid gap-2 md:grid-cols-2">
                            <form method="POST" action="{{ route('admin.verifications.approve', $verification) }}" class="space-y-2 rounded border border-green-200 p-3 dark:border-green-700">
                                @csrf
                                @method('PATCH')
                                <input name="admin_notes" placeholder="Approval notes (optional)" class="w-full rounded border border-zinc-300 px-3 py-2 text-sm dark:border-zinc-700 dark:bg-zinc-900">
                                <button class="rounded bg-green-600 px-3 py-2 text-sm text-white hover:bg-green-700">Approve Verification</button>
                            </form>

                            <form method="POST" action="{{ route('admin.verifications.reject', $verification) }}" class="space-y-2 rounded border border-red-200 p-3 dark:border-red-700">
                                @csrf
                                @method('PATCH')
                                <input name="rejection_reason" placeholder="Rejection reason (required)" class="w-full rounded border border-zinc-300 px-3 py-2 text-sm dark:border-zinc-700 dark:bg-zinc-900" required>
                                <input name="admin_notes" placeholder="Additional notes (optional)" class="w-full rounded border border-zinc-300 px-3 py-2 text-sm dark:border-zinc-700 dark:bg-zinc-900">
                                <button class="rounded bg-red-600 px-3 py-2 text-sm text-white hover:bg-red-700">Reject Verification</button>
                            </form>
                        </div>
                    @else
                        <div class="rounded-lg bg-zinc-50 p-3 text-center text-sm text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400">
                            This verification request has been {{ ucfirst($verification->status) }}.
                        </div>
                    @endif
                </div>
            @empty
                <div class="rounded border border-zinc-200 p-4 text-center text-zinc-500 dark:border-zinc-700">No verification requests found.</div>
            @endforelse
        </div>

        <div class="mt-4">{{ $verifications->links() }}</div>
    </div>
</x-layouts::app>
