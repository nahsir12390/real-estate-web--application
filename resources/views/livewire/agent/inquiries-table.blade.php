<div class="space-y-4">
    @if (session('status'))
        <div class="rounded border border-green-300 bg-green-50 p-3 text-sm text-green-700">
            {{ session('status') }}
        </div>
    @endif

    <!-- Navigation Button -->
    <div class="flex items-center justify-between gap-2">
        <div class="flex items-center gap-2">
            <select wire:model.live="status" class="rounded border border-zinc-300 px-3 py-2 text-sm dark:border-zinc-700 dark:bg-zinc-900">
                <option value="">All statuses</option>
                <option value="new">New</option>
                <option value="contacted">Contacted</option>
                <option value="closed">Closed</option>
            </select>
        </div>
        <a href="{{ route('agent.dashboard') }}"
           class="inline-flex items-center rounded-md bg-zinc-900 px-3 py-1.5 text-sm font-medium text-white hover:bg-zinc-700 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-300">
            <svg class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back
        </a>
    </div>

    <div class="space-y-3">
        @forelse($inquiries as $inquiry)
            <div class="rounded border border-zinc-200 p-4 dark:border-zinc-700">
                <div class="mb-2 text-sm text-zinc-500">{{ $inquiry->created_at }} | {{ $inquiry->property?->title }}</div>
                <p class="font-semibold">{{ $inquiry->name }} ({{ $inquiry->email }})</p>
                <p class="mb-3 text-sm">{{ $inquiry->message }}</p>

                @if($inquiry->agent_reply)
                    <div class="mb-3 rounded border border-blue-200 bg-blue-50 p-3 text-sm text-blue-900 dark:border-blue-900/40 dark:bg-blue-900/20 dark:text-blue-300">
                        <p class="font-medium">Your Reply</p>
                        <p class="mt-1">{{ $inquiry->agent_reply }}</p>
                        @if($inquiry->agent_replied_at)
                            <p class="mt-1 text-xs opacity-70">{{ $inquiry->agent_replied_at->format('M d, Y H:i') }}</p>
                        @endif
                    </div>
                @endif

                @if($inquiry->status !== 'closed')
                    <div class="mb-3">
                        <label class="mb-1 block text-xs font-medium text-zinc-600 dark:text-zinc-300">Reply to This Inquiry</label>
                        <textarea
                            wire:model.defer="replyDrafts.{{ $inquiry->id }}"
                            rows="3"
                            class="w-full rounded border border-zinc-300 px-3 py-2 text-sm dark:border-zinc-700 dark:bg-zinc-900"
                            placeholder="Type your response to this inquiry..."
                        ></textarea>
                        @error('replyDrafts.'.$inquiry->id)
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        <div class="mt-2 flex justify-end">
                            <button wire:click="sendReply({{ $inquiry->id }})" class="rounded bg-blue-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-blue-700">
                                Send Reply
                            </button>
                        </div>
                    </div>
                @endif

                <div class="flex gap-2">
                    @if($inquiry->status === 'new')
                        <button wire:click="markAs({{ $inquiry->id }}, 'contacted')" class="rounded border border-zinc-300 px-2 py-1 text-xs dark:border-zinc-700">Mark as Contacted</button>
                        <button wire:click="markAs({{ $inquiry->id }}, 'closed')" class="rounded border border-zinc-300 px-2 py-1 text-xs dark:border-zinc-700">Close</button>
                    @elseif($inquiry->status === 'contacted')
                        <button wire:click="markAs({{ $inquiry->id }}, 'closed')" class="rounded border border-zinc-300 px-2 py-1 text-xs dark:border-zinc-700">Close</button>
                    @endif
                    <span class="ms-auto text-xs text-zinc-500">{{ ucfirst($inquiry->status) }}</span>
                </div>
            </div>
        @empty
            <div class="rounded border border-zinc-200 p-4 text-center text-zinc-500 dark:border-zinc-700">No inquiries found.</div>
        @endforelse
    </div>

    <div>{{ $inquiries->links() }}</div>
</div>
