<x-layouts::app :title="$property->title">
    <div class="p-6 space-y-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <a href="{{ route('admin.properties.index') }}"
               class="inline-flex items-center gap-2 rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-300 dark:hover:bg-zinc-800">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Properties
            </a>

            <div class="flex flex-wrap gap-2">
                @if($property->status === \App\Models\Property::STATUS_PENDING)
                    <form method="POST" action="{{ route('admin.properties.approve', $property) }}">
                        @csrf
                        @method('PATCH')
                        <button class="rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-green-700">
                            Approve Property
                        </button>
                    </form>
                    <button type="button" onclick="showRejectModal()"
                            class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-red-700">
                        Reject Property
                    </button>
                @endif
                <form method="POST" action="{{ route('admin.properties.delete', $property) }}" onsubmit="return confirm('Are you sure you want to delete this property? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button class="rounded-lg bg-orange-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-orange-700">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        @if (session('status'))
            <div class="rounded-lg border border-green-300 bg-green-50 p-4 text-sm text-green-700 dark:border-green-800 dark:bg-green-900/30 dark:text-green-400">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-lg border border-red-300 bg-red-50 p-4 text-sm text-red-700 dark:border-red-800 dark:bg-red-900/30 dark:text-red-400">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
            <div class="border-b border-zinc-200 p-5 dark:border-zinc-700">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <div class="flex flex-wrap gap-2">
                            <span class="rounded-full bg-zinc-100 px-3 py-1 text-xs font-medium text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                {{ \App\Models\Property::PROPERTY_TYPES[$property->property_type] ?? ucfirst($property->property_type) }}
                            </span>
                            <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                {{ \App\Models\Property::LISTING_TYPES[$property->listing_type] ?? ucfirst($property->listing_type) }}
                            </span>
                            @php
                                $statusClass = match ($property->status) {
                                    'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                    'approved' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                    'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                    default => 'bg-zinc-100 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-300',
                                };
                            @endphp
                            <span class="rounded-full px-3 py-1 text-xs font-medium {{ $statusClass }}">
                                {{ ucfirst($property->status) }}
                            </span>
                        </div>
                        <h1 class="mt-3 text-2xl font-semibold text-zinc-900 dark:text-white">{{ $property->title }}</h1>
                        <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                            Submitted {{ $property->created_at?->format('M j, Y g:i A') }}
                        </p>
                    </div>
                    <div class="text-left sm:text-right">
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">Price</p>
                        <p class="text-2xl font-bold text-zinc-900 dark:text-white">&#8358;{{ number_format((float) $property->price, 2) }}</p>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">
                            {{ \App\Models\Property::PRICE_UNITS[$property->price_unit] ?? $property->price_unit }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 p-5 lg:grid-cols-3">
                <div class="lg:col-span-2 space-y-6">
                    <div class="space-y-3">
                        @if($property->images->isNotEmpty())
                            <div class="overflow-hidden rounded-lg border border-zinc-200 dark:border-zinc-700">
                                <img src="{{ Storage::url($property->images->sortByDesc('is_primary')->first()->image_path) }}"
                                     alt="{{ $property->title }}"
                                     class="h-96 w-full object-cover">
                            </div>
                            @if($property->images->count() > 1)
                                <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                                    @foreach($property->images as $image)
                                        <a href="{{ Storage::url($image->image_path) }}" target="_blank" rel="noopener"
                                           class="relative overflow-hidden rounded-lg border border-zinc-200 dark:border-zinc-700">
                                            <img src="{{ Storage::url($image->image_path) }}" alt="{{ $image->alt_text ?: $property->title }}" class="h-32 w-full object-cover">
                                            @if($image->is_primary)
                                                <span class="absolute left-2 top-2 rounded bg-blue-600 px-2 py-1 text-xs font-medium text-white">Primary</span>
                                            @endif
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        @else
                            <div class="flex h-80 items-center justify-center rounded-lg border border-dashed border-zinc-300 bg-zinc-50 text-sm text-zinc-500 dark:border-zinc-700 dark:bg-zinc-800/50">
                                No property images uploaded.
                            </div>
                        @endif
                    </div>

                    <section class="space-y-3">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Description</h2>
                        @if($property->short_description)
                            <p class="rounded-lg bg-zinc-50 p-4 text-sm font-medium text-zinc-700 dark:bg-zinc-800/60 dark:text-zinc-300">
                                {{ $property->short_description }}
                            </p>
                        @endif
                        <p class="whitespace-pre-line text-sm leading-6 text-zinc-700 dark:text-zinc-300">{{ $property->description }}</p>
                    </section>

                    <section class="space-y-3">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Property Details</h2>
                        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach([
                                'Bedrooms' => $property->bedrooms,
                                'Bathrooms' => $property->bathrooms,
                                'Garages' => $property->garages,
                                'Area' => $property->area ? number_format((float) $property->area, 2).' '.$property->area_unit : null,
                                'Year Built' => $property->year_built,
                                'Featured' => $property->is_featured ? 'Yes' : 'No',
                                'Premium' => $property->is_premium ? 'Yes' : 'No',
                                'Views' => number_format((int) $property->views),
                            ] as $label => $value)
                                <div class="rounded-lg border border-zinc-200 p-3 dark:border-zinc-700">
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $label }}</p>
                                    <p class="mt-1 text-sm font-medium text-zinc-900 dark:text-white">{{ $value ?: 'N/A' }}</p>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    @if(is_array($property->amenities) && count($property->amenities) > 0)
                        <section class="space-y-3">
                            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Amenities</h2>
                            <div class="flex flex-wrap gap-2">
                                @foreach($property->amenities as $amenity)
                                    <span class="rounded-full border border-zinc-300 px-3 py-1 text-sm text-zinc-700 dark:border-zinc-700 dark:text-zinc-300">{{ $amenity }}</span>
                                @endforeach
                            </div>
                        </section>
                    @endif
                </div>

                <aside class="space-y-4">
                    <section class="rounded-lg border border-zinc-200 p-4 dark:border-zinc-700">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Location</h2>
                        <div class="mt-3 space-y-2 text-sm text-zinc-700 dark:text-zinc-300">
                            <p><span class="font-medium">Address:</span> {{ $property->address ?: 'N/A' }}</p>
                            <p><span class="font-medium">City:</span> {{ $property->city }}</p>
                            <p><span class="font-medium">State:</span> {{ $property->state }}</p>
                            <p><span class="font-medium">Country:</span> {{ $property->country ?: 'N/A' }}</p>
                            <p><span class="font-medium">Zip Code:</span> {{ $property->zip_code ?: 'N/A' }}</p>
                            <p><span class="font-medium">Latitude:</span> {{ $property->latitude ?: 'N/A' }}</p>
                            <p><span class="font-medium">Longitude:</span> {{ $property->longitude ?: 'N/A' }}</p>
                        </div>
                    </section>

                    <section class="rounded-lg border border-zinc-200 p-4 dark:border-zinc-700">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Agent</h2>
                        <div class="mt-3 space-y-2 text-sm text-zinc-700 dark:text-zinc-300">
                            <p><span class="font-medium">Name:</span> {{ $property->agent?->user?->name ?: 'N/A' }}</p>
                            <p><span class="font-medium">Email:</span> {{ $property->agent?->user?->email ?: 'N/A' }}</p>
                            <p><span class="font-medium">Phone:</span> {{ $property->agent?->user?->profile?->phone ?: 'N/A' }}</p>
                            <p><span class="font-medium">Company:</span> {{ $property->agent?->company_name ?: 'N/A' }}</p>
                            <p><span class="font-medium">License:</span> {{ $property->agent?->license_number ?: 'N/A' }}</p>
                            <p><span class="font-medium">Specialization:</span> {{ $property->agent?->specialization ?: 'N/A' }}</p>
                            <p><span class="font-medium">Verification:</span> {{ ucfirst($property->agent?->verification_status ?: 'N/A') }}</p>
                        </div>
                    </section>

                    <section class="rounded-lg border border-zinc-200 p-4 dark:border-zinc-700">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Review Info</h2>
                        <div class="mt-3 space-y-2 text-sm text-zinc-700 dark:text-zinc-300">
                            <p><span class="font-medium">Status:</span> {{ ucfirst($property->status) }}</p>
                            <p><span class="font-medium">Approved By:</span> {{ $property->approver?->name ?: 'N/A' }}</p>
                            <p><span class="font-medium">Approved At:</span> {{ $property->approved_at?->format('M j, Y g:i A') ?: 'N/A' }}</p>
                            <p><span class="font-medium">Published At:</span> {{ $property->published_at?->format('M j, Y g:i A') ?: 'N/A' }}</p>
                            @if($property->rejection_reason)
                                <p class="rounded border border-red-200 bg-red-50 p-3 text-red-700 dark:border-red-900/40 dark:bg-red-900/20 dark:text-red-300">
                                    <span class="font-medium">Rejection Reason:</span> {{ $property->rejection_reason }}
                                </p>
                            @endif
                        </div>
                    </section>
                </aside>
            </div>
        </div>
    </div>

    <div id="rejectModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
        <div class="w-full max-w-md rounded-xl bg-white p-6 dark:bg-zinc-900">
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">Reject Property</h3>
            <form method="POST" action="{{ route('admin.properties.reject', $property) }}" class="mt-4">
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
                    <button type="submit" class="rounded-lg bg-red-600 px-4 py-2 text-sm text-white transition hover:bg-red-700">
                        Reject Property
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showRejectModal() {
            document.getElementById('rejectModal').style.display = 'flex';
        }

        function hideRejectModal() {
            document.getElementById('rejectModal').style.display = 'none';
        }
    </script>
</x-layouts::app>
