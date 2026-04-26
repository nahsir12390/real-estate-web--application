<div class="space-y-4">
    @php($isVerifiedAgent = auth()->user()?->agent?->isVerified() ?? false)

    @unless($isVerifiedAgent)
        <div class="rounded border border-yellow-300 bg-yellow-50 px-3 py-2 text-sm text-yellow-900">
            Your account is not verified yet. You can view your properties, but you must submit verification documents before listing or editing properties.
            <a href="{{ route('agent.verification') }}" class="ml-1 underline">Complete verification</a>
        </div>
    @endunless

    <div class="flex flex-wrap items-center justify-between gap-2">
        <div class="flex flex-wrap items-center gap-2">
            <input wire:model.live.debounce.300ms="search" placeholder="Search title..." class="rounded border border-zinc-300 px-3 py-2 text-sm dark:border-zinc-700 dark:bg-zinc-900">
            <select wire:model.live="status" class="rounded border border-zinc-300 px-3 py-2 text-sm dark:border-zinc-700 dark:bg-zinc-900">
                <option value="">All statuses</option>
                <option value="draft">Draft</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
                <option value="sold">Sold</option>
                <option value="rented">Rented</option>
            </select>
        </div>
        <div class="flex items-center gap-2">
            @if($isVerifiedAgent)
                <a href="{{ route('agent.properties.create') }}" class="rounded bg-zinc-900 px-3 py-2 text-sm text-white dark:bg-zinc-100 dark:text-zinc-900">
                    Add Property
                </a>
            @else
                <a href="{{ route('agent.verification') }}" class="rounded bg-zinc-400 px-3 py-2 text-sm text-white">
                    Verify to Add Property
                </a>
            @endif
            <a href="{{ route('agent.dashboard') }}"
               class="inline-flex items-center rounded-md bg-zinc-900 px-3 py-1.5 text-sm font-medium text-white hover:bg-zinc-700 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-300">
                <svg class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </a>
        </div>
    </div>

    <div class="overflow-x-auto rounded border border-zinc-200 dark:border-zinc-700">
        <table class="min-w-full text-sm">
            <thead class="bg-zinc-50 dark:bg-zinc-900">
                <tr>
                    <th class="px-3 py-2 text-left">Title</th>
                    <th class="px-3 py-2 text-left">Type</th>
                    <th class="px-3 py-2 text-left">Price</th>
                    <th class="px-3 py-2 text-left">Status</th>
                    <th class="px-3 py-2 text-left">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($properties as $property)
                    <tr class="border-t border-zinc-200 dark:border-zinc-700">
                        <td class="px-3 py-2">{{ $property->title }}</td>
                        <td class="px-3 py-2">{{ ucfirst($property->property_type) }} / {{ ucfirst($property->listing_type) }}</td>
                        <td class="px-3 py-2">{{ number_format((float) $property->price, 2) }}</td>
                        <td class="px-3 py-2">{{ ucfirst($property->status) }}</td>
                        <td class="px-3 py-2">
                            @if($isVerifiedAgent)
                                <a href="{{ route('agent.properties.edit', $property) }}" class="rounded border border-zinc-300 px-2 py-1 text-xs dark:border-zinc-700">
                                    Edit
                                </a>
                            @else
                                <a href="{{ route('agent.verification') }}" class="rounded border border-zinc-300 px-2 py-1 text-xs dark:border-zinc-700">
                                    Verify to Edit
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-3 py-4 text-center text-zinc-500">No properties found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>{{ $properties->links() }}</div>
</div>
