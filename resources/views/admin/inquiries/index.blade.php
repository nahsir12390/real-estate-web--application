<x-layouts::app :title="__('Manage Inquiries')">
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
                <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">Manage Inquiries</h1>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Track and manage property inquiries</p>
            </div>
            <div class="flex items-center gap-2 text-sm">
                <span class="rounded-full bg-blue-100 px-3 py-1 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                    Total: {{ $inquiries->total() }}
                </span>
            </div>
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

        <!-- Filters -->
        <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
            <form method="GET" class="flex flex-wrap gap-3">
                <select name="status" class="rounded-lg border border-zinc-300 px-4 py-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    <option value="">All Statuses</option>
                    @foreach(['new','contacted','closed'] as $s)
                        <option value="{{ $s }}" @selected($status === $s)>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <button class="rounded-lg bg-zinc-900 px-6 py-2 text-white transition hover:bg-zinc-800 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-300">
                    Filter
                </button>
                <a href="{{ route('admin.inquiries.index') }}" 
                   class="inline-flex items-center rounded-lg border border-zinc-300 px-6 py-2 text-sm text-zinc-700 transition hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-800">
                    Clear
                </a>
            </form>
        </div>

        <!-- Inquiries List -->
        <div class="space-y-4">
            @forelse($inquiries as $inquiry)
                <div class="rounded-xl border border-zinc-200 bg-white p-6 transition hover:shadow-md dark:border-zinc-700 dark:bg-zinc-900">
                    <!-- Header -->
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div class="flex items-start gap-4">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
                                    <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-zinc-900 dark:text-white">{{ $inquiry->name }}</h3>
                                <div class="mt-1 flex flex-wrap items-center gap-3 text-xs">
                                    <span class="text-zinc-500">{{ $inquiry->email }}</span>
                                    <span class="text-zinc-400">•</span>
                                    <span class="text-zinc-500">{{ $inquiry->created_at->format('M d, Y H:i') }}</span>
                                    <span class="text-zinc-400">•</span>
                                    <span class="text-zinc-500">Property: {{ $inquiry->property?->title ?: 'N/A' }}</span>
                                    <span class="text-zinc-400">•</span>
                                    <span class="text-zinc-500">Agent: {{ $inquiry->agent?->user?->name ?: 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                        @php
                            $statusClasses = match($inquiry->status) {
                                'new' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                'contacted' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                default => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                            };
                        @endphp
                        <span class="rounded-full px-3 py-1 text-xs font-medium {{ $statusClasses }}">
                            {{ ucfirst($inquiry->status) }}
                        </span>
                    </div>

                    <!-- Message -->
                    <div class="mt-4 rounded-lg bg-zinc-50 p-4 dark:bg-zinc-800">
                        <p class="text-sm text-zinc-700 dark:text-zinc-300">{{ $inquiry->message }}</p>
                    </div>

                    <!-- Update Form -->
                    <form method="POST" action="{{ route('admin.inquiries.update', $inquiry) }}" class="mt-4">
                        @csrf
                        @method('PATCH')
                        <div class="grid gap-3 md:grid-cols-12">
                            <div class="md:col-span-3">
                                <select name="status" class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                                    @foreach(['new','contacted','closed'] as $s)
                                        <option value="{{ $s }}" @selected($inquiry->status === $s)>{{ ucfirst($s) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-7">
                                <input name="admin_notes" value="{{ $inquiry->admin_notes }}" 
                                       placeholder="Add admin notes..." 
                                       class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                            </div>
                            <div class="md:col-span-2">
                                <button type="submit" 
                                        class="w-full rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Admin Notes Display -->
                    @if($inquiry->admin_notes)
                        <div class="mt-3 text-xs text-zinc-500 dark:text-zinc-400">
                            <span class="font-medium">Latest note:</span> {{ $inquiry->admin_notes }}
                        </div>
                    @endif
                </div>
            @empty
                <div class="rounded-xl border border-zinc-200 bg-white p-12 text-center dark:border-zinc-700 dark:bg-zinc-900">
                    <svg class="mx-auto h-12 w-12 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-zinc-900 dark:text-white">No Inquiries Found</h3>
                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">No inquiries match your current filters.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $inquiries->withQueryString()->links() }}
        </div>
    </div>
</x-layouts::app>