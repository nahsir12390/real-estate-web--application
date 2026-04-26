<div class="space-y-6">
    <!-- Header with Filter and Stats -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-yellow-100 dark:bg-yellow-900/30">
                <svg class="h-5 w-5 text-yellow-600 dark:text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">My Reports</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Track and manage your property reports</p>
            </div>
        </div>
        
        <div class="relative">
            <select wire:model.live="status" 
                    class="w-full appearance-none rounded-lg border border-zinc-300 bg-white py-2 pl-4 pr-10 text-sm focus:border-yellow-500 focus:outline-none focus:ring-1 focus:ring-yellow-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white sm:w-48">
                <option value="">All Statuses</option>
                <option value="pending">Pending</option>
                <option value="reviewed">Reviewed</option>
                <option value="resolved">Resolved</option>
                <option value="dismissed">Dismissed</option>
            </select>
            <svg class="absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </div>

    <!-- Status Summary Cards -->
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        @php
            $statusCounts = [
                'pending' => $reports->where('status', 'pending')->count(),
                'reviewed' => $reports->where('status', 'reviewed')->count(),
                'resolved' => $reports->where('status', 'resolved')->count(),
                'dismissed' => $reports->where('status', 'dismissed')->count(),
            ];
            
            $statusColors = [
                'pending' => 'border-yellow-200 bg-yellow-50 dark:border-yellow-900/50 dark:bg-yellow-900/20',
                'reviewed' => 'border-blue-200 bg-blue-50 dark:border-blue-900/50 dark:bg-blue-900/20',
                'resolved' => 'border-green-200 bg-green-50 dark:border-green-900/50 dark:bg-green-900/20',
                'dismissed' => 'border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800',
            ];
            
            $textColors = [
                'pending' => 'text-yellow-700 dark:text-yellow-300',
                'reviewed' => 'text-blue-700 dark:text-blue-300',
                'resolved' => 'text-green-700 dark:text-green-300',
                'dismissed' => 'text-zinc-700 dark:text-zinc-300',
            ];
        @endphp
        
        @foreach(['pending', 'reviewed', 'resolved', 'dismissed'] as $status)
            <div class="rounded-lg border {{ $statusColors[$status] }} p-3">
                <p class="text-xs {{ $textColors[$status] }}">{{ ucfirst($status) }}</p>
                <p class="text-xl font-semibold {{ $textColors[$status] }}">{{ $statusCounts[$status] }}</p>
            </div>
        @endforeach
    </div>

    <!-- Reports List -->
    @if($reports->isEmpty())
        <div class="flex flex-col items-center justify-center rounded-xl border border-zinc-200 bg-white py-16 dark:border-zinc-700 dark:bg-zinc-900">
            <svg class="h-16 w-16 text-zinc-300 dark:text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <h3 class="mt-4 text-lg font-medium text-zinc-900 dark:text-white">No reports found</h3>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                @if($status)
                    No {{ $status }} reports match your filter.
                @else
                    You haven't submitted any reports yet.
                @endif
            </p>
            @if($status)
                <button wire:click="$set('status', '')" 
                        class="mt-4 rounded-lg bg-zinc-100 px-4 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-200 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700">
                    Clear Filter
                </button>
            @else
                <a href="{{ route('user.home') }}" 
                   class="mt-4 rounded-lg bg-yellow-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-yellow-700">
                    Browse Properties
                </a>
            @endif
        </div>
    @else
        <!-- Desktop Table View (hidden on mobile) -->
        <div class="hidden overflow-hidden rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900 md:block">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800">
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Property</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Reason</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Description</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @foreach($reports as $report)
                            <tr class="transition hover:bg-zinc-50 dark:hover:bg-zinc-800">
                                <td class="px-4 py-3">
                                    @if($report->property)
                                        <div class="font-medium text-zinc-900 dark:text-white">{{ $report->property->title }}</div>
                                    @else
                                        <span class="text-zinc-500">Property unavailable</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <span class="rounded-full bg-zinc-100 px-2 py-1 text-xs dark:bg-zinc-800">
                                        {{ ucfirst(str_replace('_', ' ', $report->reason)) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="max-w-xs">
                                        <p class="text-sm text-zinc-700 dark:text-zinc-300">{{ Str::limit($report->description ?? 'No description provided', 50) }}</p>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                            'reviewed' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                            'resolved' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                            'dismissed' => 'bg-zinc-100 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-400',
                                        ];
                                    @endphp
                                    <span class="rounded-full px-2 py-1 text-xs font-medium {{ $statusColors[$report->status] ?? 'bg-zinc-100' }}">
                                        {{ ucfirst($report->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400">
                                    {{ $report->created_at->format('M d, Y') }}
                                    <div class="text-xs text-zinc-500">{{ $report->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <button wire:click="viewReport({{ $report->id }})"
                                            class="rounded-lg bg-yellow-600 px-3 py-1.5 text-xs font-medium text-white transition hover:bg-yellow-700">
                                        View Details
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile Card View (visible on mobile) -->
        <div class="grid gap-4 md:hidden">
            @foreach($reports as $report)
                <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
                    <!-- Header -->
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="font-semibold text-zinc-900 dark:text-white">
                                {{ $report->property?->title ?? 'Property unavailable' }}
                            </h3>
                            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                                Reason: {{ ucfirst(str_replace('_', ' ', $report->reason)) }}
                            </p>
                        </div>
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                'reviewed' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                'resolved' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                'dismissed' => 'bg-zinc-100 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-400',
                            ];
                        @endphp
                        <span class="rounded-full px-2 py-1 text-xs font-medium {{ $statusColors[$report->status] ?? 'bg-zinc-100' }}">
                            {{ ucfirst($report->status) }}
                        </span>
                    </div>

                    <!-- Description -->
                    @if($report->description)
                        <div class="mt-3 rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800">
                            <p class="text-sm text-zinc-700 dark:text-zinc-300">{{ $report->description }}</p>
                        </div>
                    @endif

                    <!-- Footer -->
                    <div class="mt-3 flex items-center justify-between">
                        <div class="text-sm text-zinc-500 dark:text-zinc-400">
                            {{ $report->created_at->format('M d, Y') }}
                            <span class="text-xs">({{ $report->created_at->diffForHumans() }})</span>
                        </div>
                        <button wire:click="viewReport({{ $report->id }})"
                                class="rounded-lg bg-yellow-600 px-3 py-1.5 text-sm font-medium text-white transition hover:bg-yellow-700">
                            Details
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $reports->links() }}
        </div>
    @endif

    <!-- Report Details Modal -->
    @if($selectedReport)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div class="max-h-[90vh] w-full max-w-2xl overflow-y-auto rounded-xl bg-white p-6 dark:bg-zinc-900">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">Report Details</h3>
                    <button wire:click="$set('selectedReport', null)" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="mt-4 space-y-4">
                    <!-- Status -->
                    <div>
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Status</p>
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                'reviewed' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                'resolved' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                'dismissed' => 'bg-zinc-100 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-400',
                            ];
                        @endphp
                        <span class="mt-1 inline-block rounded-full px-2 py-1 text-xs font-medium {{ $statusColors[$selectedReport->status] ?? 'bg-zinc-100' }}">
                            {{ ucfirst($selectedReport->status) }}
                        </span>
                    </div>

                    <!-- Property Info -->
                    <div>
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Property</p>
                        @if($selectedReport->property)
                            <p class="mt-1 text-zinc-900 dark:text-white">{{ $selectedReport->property->title }}</p>
                        @else
                            <p class="mt-1 text-zinc-500">Property unavailable</p>
                        @endif
                    </div>

                    <!-- Reason -->
                    <div>
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Reason</p>
                        <p class="mt-1 text-zinc-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $selectedReport->reason)) }}</p>
                    </div>

                    <!-- Description -->
                    <div>
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Description</p>
                        <div class="mt-1 rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800">
                            <p class="text-zinc-700 dark:text-zinc-300">{{ $selectedReport->description ?: 'No description provided' }}</p>
                        </div>
                    </div>

                    <!-- Timestamps -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Submitted</p>
                            <p class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $selectedReport->created_at->format('M d, Y H:i') }}</p>
                            <p class="text-xs text-zinc-500">{{ $selectedReport->created_at->diffForHumans() }}</p>
                        </div>
                        @if($selectedReport->resolved_at)
                            <div>
                                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Resolved</p>
                                <p class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $selectedReport->resolved_at->format('M d, Y H:i') }}</p>
                                <p class="text-xs text-zinc-500">{{ $selectedReport->resolved_at->diffForHumans() }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Admin Notes -->
                    @if($selectedReport->admin_notes)
                        <div>
                            <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Admin Notes</p>
                            <p class="mt-1 text-sm text-zinc-700 dark:text-zinc-300">{{ $selectedReport->admin_notes }}</p>
                        </div>
                    @endif

                    <!-- Resolution Info -->
                    @if($selectedReport->resolved_by)
                        <div>
                            <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Resolved By</p>
                            <p class="mt-1 text-sm text-zinc-900 dark:text-white">Administrator</p>
                        </div>
                    @endif
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    @if($selectedReport->status === 'pending')
                        <button wire:click="cancelReport({{ $selectedReport->id }})"
                                wire:confirm="Are you sure you want to cancel this report?"
                                class="rounded-lg border border-red-300 px-4 py-2 text-sm font-medium text-red-700 transition hover:bg-red-50 dark:border-red-700 dark:text-red-400 dark:hover:bg-red-900/20">
                            Cancel Report
                        </button>
                    @endif
                    <button wire:click="$set('selectedReport', null)" 
                            class="rounded-lg bg-zinc-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-zinc-800 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-300">
                        Close
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>