<x-layouts.guest :title="$property->title">
    <a href="{{ route('properties.index') }}" class="inline-flex items-center rounded border border-zinc-300 px-3 py-1.5 text-sm dark:border-zinc-700">
        Back to properties
    </a>

    <div class="mt-4 grid gap-6 lg:grid-cols-2">
        <div>
            <div class="overflow-hidden rounded-xl border border-zinc-200 dark:border-zinc-700">
                @if($property->images->first()?->image_path)
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($property->images->sortByDesc('is_primary')->first()->image_path) }}" alt="{{ $property->title }}" class="h-80 w-full object-cover">
                @else
                    <div class="flex h-80 items-center justify-center bg-zinc-100 text-sm text-zinc-500 dark:bg-zinc-800">No image</div>
                @endif
            </div>
        </div>

        <div class="space-y-3">
            <h1 class="text-2xl font-semibold text-zinc-900 dark:text-zinc-100">{{ $property->title }}</h1>
            <p class="text-sm text-zinc-500">{{ ucfirst($property->listing_type) }} • {{ ucfirst($property->property_type) }}</p>
            <p class="text-xl font-bold text-zinc-900 dark:text-zinc-100">{{ number_format((float) $property->price, 2) }}</p>
            <p class="text-sm text-zinc-700 dark:text-zinc-300">{{ $property->address }}, {{ $property->city }}, {{ $property->state }}</p>
            <p class="text-sm text-zinc-700 dark:text-zinc-300">{{ $property->description }}</p>

            <div class="rounded-lg border border-zinc-200 bg-zinc-50 p-3 dark:border-zinc-700 dark:bg-zinc-800/50">
                <p class="font-medium text-zinc-900 dark:text-zinc-100">Agent Information</p>
                <p class="text-sm text-zinc-700 dark:text-zinc-300">Name: {{ $property->agent?->user?->name ?? 'N/A' }}</p>
                <p class="text-sm text-zinc-700 dark:text-zinc-300">Company: {{ $property->agent?->company_name ?: 'N/A' }}</p>
                <p class="text-sm text-zinc-700 dark:text-zinc-300">Email: {{ $property->agent?->user?->email ?: 'N/A' }}</p>
                <p class="text-sm text-zinc-700 dark:text-zinc-300">Phone: {{ $property->agent?->user?->profile?->phone ?: 'N/A' }}</p>
            </div>

            <div class="rounded border border-blue-200 bg-blue-50 p-3 text-sm text-blue-800 dark:border-blue-900/40 dark:bg-blue-900/20 dark:text-blue-300">
                Login to save as favorite, comment, or send inquiry to this agent.
                <a href="{{ route('login') }}" class="ml-1 underline">Login now</a>
            </div>
        </div>
    </div>
</x-layouts.guest>
