<x-layouts::app :title="__('Manage Reports')">
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
        <h1 class="mb-4 text-2xl font-semibold">Manage Reports</h1>

        @if (session('status'))
            <div class="mb-4 rounded border border-green-300 bg-green-50 p-3 text-sm text-green-700">{{ session('status') }}</div>
        @endif

        <form method="GET" class="mb-4 flex gap-2">
            <select name="status" class="rounded border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-900">
                <option value="">All statuses</option>
                @foreach(['pending','reviewed','resolved','dismissed'] as $s)
                    <option value="{{ $s }}" @selected($status === $s)>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            <button class="rounded bg-zinc-900 px-3 py-2 text-white dark:bg-zinc-100 dark:text-zinc-900">Filter</button>
        </form>

        <div class="space-y-3">
            @forelse($reports as $report)
                <div class="rounded border border-zinc-200 p-4 dark:border-zinc-700">
                    <div class="mb-2 text-sm text-zinc-500">
                        {{ $report->created_at }} | {{ $report->property?->title }} | by {{ $report->user?->name }}
                    </div>
                    <div class="mb-3">
                        <div class="font-semibold">Reason: {{ ucfirst(str_replace('_', ' ', $report->reason)) }}</div>
                        <p>{{ $report->description ?: '-' }}</p>
                    </div>
                    <form method="POST" action="{{ route('admin.reports.update', $report) }}" class="grid gap-2 md:grid-cols-3">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="rounded border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-900">
                            @foreach(['pending','reviewed','resolved','dismissed'] as $s)
                                <option value="{{ $s }}" @selected($report->status === $s)>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                        <input name="admin_notes" value="{{ $report->admin_notes }}" placeholder="Admin notes" class="rounded border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-900 md:col-span-2">
                        <button class="rounded bg-blue-600 px-3 py-2 text-white md:col-span-3">Update Report</button>
                    </form>
                </div>
            @empty
                <div class="rounded border border-zinc-200 p-4 text-center text-zinc-500 dark:border-zinc-700">No reports found.</div>
            @endforelse
        </div>

        <div class="mt-4">{{ $reports->links() }}</div>
    </div>
</x-layouts::app>
