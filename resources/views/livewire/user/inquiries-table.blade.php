<div class="space-y-6">
    <!-- Header with Filter and Stats -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30">
                <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
                    <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z" />
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">My Inquiries</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Track and manage your property inquiries</p>
            </div>
        </div>
        
        <div class="relative">
            <select wire:model.live="status" 
                    class="w-full appearance-none rounded-lg border border-zinc-300 bg-white py-2 pl-4 pr-10 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white sm:w-48">
                <option value="">All Statuses</option>
                <option value="new">New</option>
                <option value="contacted">Contacted</option>
                <option value="closed">Closed</option>
            </select>
            <svg class="absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </div>

    <!-- Status Summary Cards -->
    <div class="grid grid-cols-3 gap-3">
        @php
            $statusCounts = [
                'new' => $inquiries->where('status', 'new')->count(),
                'contacted' => $inquiries->where('status', 'contacted')->count(),
                'closed' => $inquiries->where('status', 'closed')->count(),
            ];
        @endphp
        
        <div class="rounded-lg border border-yellow-200 bg-yellow-50 p-3 dark:border-yellow-900/50 dark:bg-yellow-900/20">
            <p class="text-xs text-yellow-600 dark:text-yellow-400">New</p>
            <p class="text-xl font-semibold text-yellow-700 dark:text-yellow-300">{{ $statusCounts['new'] }}</p>
        </div>
        <div class="rounded-lg border border-blue-200 bg-blue-50 p-3 dark:border-blue-900/50 dark:bg-blue-900/20">
            <p class="text-xs text-blue-600 dark:text-blue-400">Contacted</p>
            <p class="text-xl font-semibold text-blue-700 dark:text-blue-300">{{ $statusCounts['contacted'] }}</p>
        </div>
        <div class="rounded-lg border border-green-200 bg-green-50 p-3 dark:border-green-900/50 dark:bg-green-900/20">
            <p class="text-xs text-green-600 dark:text-green-400">Closed</p>
            <p class="text-xl font-semibold text-green-700 dark:text-green-300">{{ $statusCounts['closed'] }}</p>
        </div>
    </div>

    <!-- Inquiries List -->
    @if($inquiries->isEmpty())
        <div class="flex flex-col items-center justify-center rounded-xl border border-zinc-200 bg-white py-16 dark:border-zinc-700 dark:bg-zinc-900">
            <svg class="h-16 w-16 text-zinc-300 dark:text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            <h3 class="mt-4 text-lg font-medium text-zinc-900 dark:text-white">No inquiries found</h3>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                @if($status)
                    No {{ $status }} inquiries match your filter.
                @else
                    You haven't made any inquiries yet.
                @endif
            </p>
            @if($status)
                <button wire:click="$set('status', '')" 
                        class="mt-4 rounded-lg bg-zinc-100 px-4 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-200 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700">
                    Clear Filter
                </button>
            @else
                <a href="{{ route('user.home') }}" 
                   class="mt-4 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
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
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Agent</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Message</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @foreach($inquiries as $inquiry)
                            <tr class="transition hover:bg-zinc-50 dark:hover:bg-zinc-800">
                                <td class="px-4 py-3">
                                    @if($inquiry->property)
                                        <div class="font-medium text-zinc-900 dark:text-white">{{ $inquiry->property->title }}</div>
                                        <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ $inquiry->property->city }}, {{ $inquiry->property->state }}</div>
                                    @else
                                        <span class="text-zinc-500">Property unavailable</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($inquiry->agent)
                                        <div class="font-medium text-zinc-900 dark:text-white">{{ $inquiry->agent->user?->name ?? 'Unknown' }}</div>
                                        <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ $inquiry->agent->user?->email ?? 'N/A' }}</div>
                                    @else
                                        <span class="text-zinc-500">N/A</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="max-w-xs">
                                        <p class="text-sm text-zinc-700 dark:text-zinc-300">{{ Str::limit($inquiry->message, 60) }}</p>
                                        @if($inquiry->agent_reply)
                                            <p class="mt-1 text-xs text-blue-700 dark:text-blue-400">Agent replied</p>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $statusColors = [
                                            'new' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                            'contacted' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                            'closed' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                        ];
                                    @endphp
                                    <span class="rounded-full px-2 py-1 text-xs font-medium {{ $statusColors[$inquiry->status] ?? 'bg-zinc-100' }}">
                                        {{ ucfirst($inquiry->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400">
                                    {{ $inquiry->created_at->format('M d, Y') }}
                                    <div class="text-xs text-zinc-500">{{ $inquiry->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <button wire:click="viewInquiry({{ $inquiry->id }})"
                                            class="rounded-lg bg-blue-600 px-3 py-1.5 text-xs font-medium text-white transition hover:bg-blue-700">
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
            @foreach($inquiries as $inquiry)
                <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
                    <!-- Header -->
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="font-semibold text-zinc-900 dark:text-white">
                                {{ $inquiry->property?->title ?? 'Property unavailable' }}
                            </h3>
                            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                                Agent: {{ $inquiry->agent?->user?->name ?? 'N/A' }}
                            </p>
                        </div>
                        @php
                            $statusColors = [
                                'new' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                'contacted' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                'closed' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                            ];
                        @endphp
                        <span class="rounded-full px-2 py-1 text-xs font-medium {{ $statusColors[$inquiry->status] ?? 'bg-zinc-100' }}">
                            {{ ucfirst($inquiry->status) }}
                        </span>
                    </div>

                    <!-- Location -->
                    @if($inquiry->property)
                        <div class="mt-2 flex items-center gap-1 text-sm text-zinc-600 dark:text-zinc-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $inquiry->property->city }}, {{ $inquiry->property->state }}
                        </div>
                    @endif

                    <!-- Message -->
                    <div class="mt-3 rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800">
                        <p class="text-sm text-zinc-700 dark:text-zinc-300">{{ $inquiry->message }}</p>
                    </div>

                    @if($inquiry->agent_reply)
                        <div class="mt-3 rounded-lg border border-blue-200 bg-blue-50 p-3 dark:border-blue-900/40 dark:bg-blue-900/20">
                            <p class="text-xs font-medium text-blue-800 dark:text-blue-300">Agent Reply</p>
                            <p class="mt-1 text-sm text-blue-900 dark:text-blue-200">{{ $inquiry->agent_reply }}</p>
                        </div>
                    @endif

                    <!-- Footer -->
                    <div class="mt-3 flex items-center justify-between">
                        <div class="text-sm text-zinc-500 dark:text-zinc-400">
                            {{ $inquiry->created_at->format('M d, Y') }}
                            <span class="text-xs">({{ $inquiry->created_at->diffForHumans() }})</span>
                        </div>
                        <button wire:click="viewInquiry({{ $inquiry->id }})"
                                class="rounded-lg bg-blue-600 px-3 py-1.5 text-sm font-medium text-white transition hover:bg-blue-700">
                            Details
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $inquiries->links() }}
        </div>
    @endif

    <!-- Inquiry Details Modal -->
    @if($selectedInquiry)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" wire:click="closeModal()">
            <div class="max-h-[90vh] w-full max-w-2xl overflow-y-auto rounded-xl bg-white p-6 dark:bg-zinc-900" wire:click.stop>
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">Inquiry Details</h3>
                    <button wire:click="closeModal()" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300">
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
                                'new' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                'contacted' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                'closed' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                            ];
                        @endphp
                        <span class="mt-1 inline-block rounded-full px-2 py-1 text-xs font-medium {{ $statusColors[$selectedInquiry->status] ?? 'bg-zinc-100' }}">
                            {{ ucfirst($selectedInquiry->status) }}
                        </span>
                    </div>

                    <!-- Property Info -->
                    <div>
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Property</p>
                        @if($selectedInquiry->property)
                            <p class="mt-1 text-zinc-900 dark:text-white">{{ $selectedInquiry->property->title }}</p>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400">
                                {{ $selectedInquiry->property->city }}, {{ $selectedInquiry->property->state }}
                            </p>
                        @else
                            <p class="mt-1 text-zinc-500">Property unavailable</p>
                        @endif
                    </div>

                    <!-- Agent Info -->
                    <div>
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Agent</p>
                        @if($selectedInquiry->agent)
                            <p class="mt-1 text-zinc-900 dark:text-white">{{ $selectedInquiry->agent->user?->name ?? 'Unknown' }}</p>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ $selectedInquiry->agent->user?->email ?? 'N/A' }}</p>
                        @else
                            <p class="mt-1 text-zinc-500">N/A</p>
                        @endif
                    </div>

                    <!-- Message -->
                    <div>
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Your Message</p>
                        <div class="mt-1 rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800">
                            <p class="text-zinc-700 dark:text-zinc-300">{{ $selectedInquiry->message }}</p>
                        </div>
                    </div>

                    <!-- Timestamps -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Sent</p>
                            <p class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $selectedInquiry->created_at->format('M d, Y H:i') }}</p>
                            <p class="text-xs text-zinc-500">{{ $selectedInquiry->created_at->diffForHumans() }}</p>
                        </div>
                        @if($selectedInquiry->responded_at)
                            <div>
                                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Responded</p>
                                <p class="mt-1 text-sm text-zinc-900 dark:text-white">{{ $selectedInquiry->responded_at->format('M d, Y H:i') }}</p>
                                <p class="text-xs text-zinc-500">{{ $selectedInquiry->responded_at->diffForHumans() }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Admin Notes -->
                    @if($selectedInquiry->admin_notes)
                        <div>
                            <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Admin Notes</p>
                            <p class="mt-1 text-sm text-zinc-700 dark:text-zinc-300">{{ $selectedInquiry->admin_notes }}</p>
                        </div>
                    @endif

                    @if($selectedInquiry->agent_reply)
                        <div>
                            <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Agent Reply</p>
                            <div class="mt-1 rounded-lg border border-blue-200 bg-blue-50 p-3 text-sm text-blue-900 dark:border-blue-900/40 dark:bg-blue-900/20 dark:text-blue-300">
                                {{ $selectedInquiry->agent_reply }}
                            </div>
                            @if($selectedInquiry->agent_replied_at)
                                <p class="mt-1 text-xs text-zinc-500">Replied {{ $selectedInquiry->agent_replied_at->diffForHumans() }}</p>
                            @endif
                        </div>
                    @endif

                    <!-- Contact Info -->
                    @if($selectedInquiry->preferred_contact)
                        <div>
                            <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Preferred Contact Method</p>
                            <p class="mt-1 text-sm text-zinc-700 dark:text-zinc-300">{{ ucfirst($selectedInquiry->preferred_contact) }}</p>
                        </div>
                    @endif
                </div>

                <div class="mt-6 flex justify-end">
                    <button wire:click="closeModal()" 
                            class="rounded-lg bg-zinc-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-zinc-800 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-300">
                        Close
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
