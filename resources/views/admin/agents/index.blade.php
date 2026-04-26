<x-layouts::app :title="__('Manage Agents')">
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
                <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">Manage Agents</h1>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Review and manage agent verifications</p>
            </div>
            <div class="flex items-center gap-2 text-sm">
                <span class="rounded-full bg-blue-100 px-3 py-1 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                    Total: {{ $agents->total() }}
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
            <form method="GET" class="grid gap-3 md:grid-cols-4">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input name="search" value="{{ $search }}" placeholder="Search by name or email" 
                           class="w-full rounded-lg border border-zinc-300 py-2 pl-10 pr-3 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                </div>
                <select name="status" class="rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                    <option value="">All statuses</option>
                    <option value="pending" @selected($status === 'pending')>Pending</option>
                    <option value="verified" @selected($status === 'verified')>Verified</option>
                    <option value="rejected" @selected($status === 'rejected')>Rejected</option>
                </select>
                <button class="rounded-lg bg-zinc-900 px-4 py-2 text-white transition hover:bg-zinc-800 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-300">
                    Apply Filters
                </button>
                <a href="{{ route('admin.agents.index') }}" 
                   class="inline-flex items-center justify-center rounded-lg border border-zinc-300 px-4 py-2 text-sm text-zinc-700 transition hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-800">
                    Clear
                </a>
            </form>
        </div>

        <!-- Agents Table -->
        <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800">
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Agent</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Company</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Joined</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse($agents as $agent)
                            <tr class="transition hover:bg-zinc-50 dark:hover:bg-zinc-800">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-zinc-200 text-sm font-medium text-zinc-700 dark:bg-zinc-700 dark:text-zinc-300">
                                            {{ substr($agent->user->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <div class="font-medium text-zinc-900 dark:text-white">{{ $agent->user->name }}</div>
                                            <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ $agent->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                            'verified' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                            'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                        ];
                                    @endphp
                                    <span class="inline-flex rounded-full px-2 py-1 text-xs font-medium {{ $statusColors[$agent->verification_status] ?? 'bg-zinc-100 text-zinc-800' }}">
                                        {{ ucfirst($agent->verification_status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-zinc-700 dark:text-zinc-300">
                                    {{ $agent->company_name ?: '-' }}
                                </td>
                                <td class="px-4 py-3 text-xs text-zinc-500 dark:text-zinc-400">
                                    {{ $agent->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-col gap-2">
                                        @if($agent->verification_status === 'pending')
                                            <div class="flex flex-wrap gap-2">
                                                <form method="POST" action="{{ route('admin.agents.approve', $agent) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="rounded-lg bg-green-600 px-3 py-1.5 text-xs font-medium text-white transition hover:bg-green-700">
                                                        <span class="flex items-center gap-1">
                                                            <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                            </svg>
                                                            Approve
                                                        </span>
                                                    </button>
                                                </form>
                                                <button onclick="showRejectModal({{ $agent->id }})" 
                                                        class="rounded-lg bg-red-600 px-3 py-1.5 text-xs font-medium text-white transition hover:bg-red-700">
                                                    <span class="flex items-center gap-1">
                                                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                        </svg>
                                                        Reject
                                                    </span>
                                                </button>
                                            </div>
                                        @endif
                                        @if($agent->rejection_reason)
                                            <div class="text-xs text-red-600 dark:text-red-400">
                                                <span class="font-medium">Reason:</span> {{ $agent->rejection_reason }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-zinc-500 dark:text-zinc-400">
                                    <svg class="mx-auto h-12 w-12 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    <p class="mt-2">No agents found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $agents->withQueryString()->links() }}
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">
        <div class="w-full max-w-md rounded-xl bg-white p-6 dark:bg-zinc-900">
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">Reject Agent</h3>
            <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">Please provide a reason for rejection.</p>
            <form method="POST" action="" id="rejectForm" class="mt-4">
                @csrf
                @method('PATCH')
                <textarea name="rejection_reason" rows="3" 
                          class="w-full rounded-lg border border-zinc-300 p-3 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white" 
                          placeholder="Enter rejection reason..." required></textarea>
                <div class="mt-4 flex justify-end gap-2">
                    <button type="button" onclick="hideRejectModal()" 
                            class="rounded-lg border border-zinc-300 px-4 py-2 text-sm text-zinc-700 transition hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-800">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="rounded-lg bg-red-600 px-4 py-2 text-sm text-white transition hover:bg-red-700">
                        Reject Agent
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showRejectModal(agentId) {
            document.getElementById('rejectModal').style.display = 'flex';
            const baseUrl = '{{ url("/admin/agents") }}';
            document.getElementById('rejectForm').action = baseUrl + '/' + agentId + '/reject';
        }

        function hideRejectModal() {
            document.getElementById('rejectModal').style.display = 'none';
        }
    </script>
</x-layouts::app>