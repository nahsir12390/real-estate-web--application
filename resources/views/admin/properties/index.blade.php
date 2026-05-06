<x-layouts::app :title="__('Manage Properties')">
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
                <h1 class="text-2xl font-semibold text-zinc-900 dark:text-white">Manage Properties</h1>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Review, approve, and manage property listings</p>
            </div>
            <span class="rounded-full bg-blue-100 px-3 py-1 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                Total: {{ $properties->total() }}
            </span>
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

        @if ($errors->any())
            <div class="rounded-lg border border-red-300 bg-red-50 p-4 text-sm text-red-700 dark:border-red-800 dark:bg-red-900/30 dark:text-red-400">
                <div class="mb-2 font-medium">Please fix the following errors:</div>
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Add Property Form (Collapsible) -->
        <div class="rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
            <button type="button" onclick="toggleAddProperty()" 
                    class="flex w-full items-center justify-between p-4 text-left">
                <div>
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Add New Property</h2>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">Create a new property listing for any verified agent</p>
                </div>
                <svg id="toggleIcon" class="h-5 w-5 text-zinc-500 transition-transform {{ $errors->any() ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            
            <div id="addPropertyForm" class="{{ $errors->any() ? '' : 'hidden' }} border-t border-zinc-200 p-4 dark:border-zinc-700">
                <form method="POST" action="{{ route('admin.properties.store') }}" enctype="multipart/form-data" class="grid gap-4 md:grid-cols-3">
                    @csrf
                    
                    <!-- Agent Selection -->
                    <div class="md:col-span-3">
                        <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Select Agent *</label>
                        <select name="agent_id" class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800" required>
                            <option value="">Choose a verified agent</option>
                            @foreach($verifiedAgents as $agent)
                                <option value="{{ $agent->id }}" @selected(old('agent_id') == $agent->id)>{{ $agent->user->name }} ({{ $agent->user->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Basic Info -->
                    <div class="md:col-span-2">
                        <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Title *</label>
                        <input name="title" value="{{ old('title') }}" placeholder="e.g., Modern 3-Bedroom House in Ikeja" required
                               class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Property Type *</label>
                        <select name="property_type" id="adminPropertyType" class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800" required>
                            <option value="">Select type</option>
                            @foreach(\App\Models\Property::PROPERTY_TYPES as $value => $label)
                                <option value="{{ $value }}" @selected(old('property_type') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Pricing -->
                    <div>
                        <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Listing Type *</label>
                        <select name="listing_type" id="adminListingType" class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800" required>
                            @foreach(\App\Models\Property::LISTING_TYPES as $value => $label)
                                <option value="{{ $value }}" @selected(old('listing_type', 'sale') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Price *</label>
                        <input name="price" value="{{ old('price') }}" type="number" step="0.01" placeholder="0.00" required
                               class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Price Unit</label>
                        <select name="price_unit" id="adminPriceUnit" class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800">
                            @foreach(\App\Models\Property::PRICE_UNITS as $value => $label)
                                <option value="{{ $value }}" @selected(old('price_unit', 'total') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Status</label>
                        <select name="status" class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800">
                            <option value="approved" @selected(old('status', 'approved') === 'approved')>Approved (Publish Now)</option>
                            <option value="pending" @selected(old('status') === 'pending')>Pending Review</option>
                            <option value="draft" @selected(old('status') === 'draft')>Draft</option>
                        </select>
                    </div>

                    <!-- Location -->
                    <div class="md:col-span-2">
                        <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Address <span class="text-xs text-zinc-500">(Optional)</span></label>
                        <input name="address" value="{{ old('address') }}" placeholder="Street address"
                               class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">City *</label>
                        <input name="city" value="{{ old('city') }}" placeholder="e.g., Lagos" required
                               class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">State *</label>
                        <select name="state" class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800" required>
                            <option value="">Select State</option>
                            @foreach($nigerianStates as $ngState)
                                <option value="{{ $ngState }}" @selected(old('state') === $ngState)>{{ $ngState }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Country</label>
                        <input name="country" value="{{ old('country', 'Nigeria') }}"
                               class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Zip Code</label>
                        <input name="zip_code" value="{{ old('zip_code') }}" placeholder="e.g., 100001"
                               class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800">
                    </div>

                    <!-- Property Details -->
                    <div data-property-field="bedrooms">
                        <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Bedrooms</label>
                        <input name="bedrooms" value="{{ old('bedrooms') }}" type="number" min="0" placeholder="e.g., 3"
                               class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800">
                    </div>
                    <div data-property-field="bathrooms">
                        <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Bathrooms</label>
                        <input name="bathrooms" value="{{ old('bathrooms') }}" type="number" min="0" placeholder="e.g., 2"
                               class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800">
                    </div>
                    <div data-property-field="garages">
                        <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Garages</label>
                        <input name="garages" value="{{ old('garages') }}" type="number" min="0" placeholder="e.g., 1"
                               class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800">
                    </div>
                    <div data-property-field="area">
                        <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Area</label>
                        <input name="area" value="{{ old('area') }}" type="number" step="0.01" placeholder="e.g., 200"
                               class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800">
                    </div>
                    <div data-property-field="area">
                        <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Area Unit</label>
                        <select name="area_unit" class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800">
                            @foreach(\App\Models\Property::AREA_UNITS as $value => $label)
                                <option value="{{ $value }}" @selected(old('area_unit', 'sqm') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div data-property-field="year_built">
                        <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Year Built</label>
                        <input name="year_built" value="{{ old('year_built') }}" type="number" min="1900" max="2100" placeholder="e.g., 2020"
                               class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800">
                    </div>

                    <!-- Descriptions -->
                    <div class="md:col-span-3">
                        <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Short Description</label>
                        <textarea name="short_description" rows="2" placeholder="Brief summary (max 500 chars)"
                                  class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800">{{ old('short_description') }}</textarea>
                    </div>
                    <div class="md:col-span-3">
                        <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Full Description <span class="text-xs text-zinc-500">(Optional)</span></label>
                        <textarea name="description" rows="4" placeholder="Detailed property description..."
                                  class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800">{{ old('description') }}</textarea>
                    </div>

                    <!-- Amenities -->
                    <div class="md:col-span-3" data-property-field="amenities">
                        <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Amenities</label>
                        <textarea name="amenities" rows="2" 
                                  placeholder="Enter amenities (comma-separated)&#10;e.g.: Borehole, Security, Parking, Swimming Pool"
                                  class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800">{{ old('amenities') }}</textarea>
                    </div>

                    <!-- Images -->
                    <div class="md:col-span-3">
                        <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Property Images <span class="text-xs text-zinc-500">(Optional)</span></label>
                        <input name="images[]" type="file" multiple accept="image/*"
                               class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm dark:border-zinc-700 dark:bg-zinc-800">
                        <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">You can upload multiple images. The first selected image will be used as the primary image.</p>
                    </div>

                    <!-- Coordinates -->
                    <div>
                        <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Latitude <span class="text-xs text-zinc-500">(Optional)</span></label>
                        <input name="latitude" value="{{ old('latitude') }}" type="number" step="0.00000001" placeholder="e.g., 6.5244"
                               class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Longitude <span class="text-xs text-zinc-500">(Optional)</span></label>
                        <input name="longitude" value="{{ old('longitude') }}" type="number" step="0.00000001" placeholder="e.g., 3.3792"
                               class="w-full rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800">
                    </div>

                    <!-- Options -->
                    <div class="md:col-span-3 flex items-center gap-6">
                        <label class="flex items-center gap-2 text-sm text-zinc-700 dark:text-zinc-300">
                            <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured')) class="rounded border-zinc-300">
                            Featured Property
                        </label>
                        <label class="flex items-center gap-2 text-sm text-zinc-700 dark:text-zinc-300">
                            <input type="checkbox" name="is_premium" value="1" @checked(old('is_premium')) class="rounded border-zinc-300">
                            Premium Listing
                        </label>
                    </div>

                    <!-- Submit -->
                    <div class="md:col-span-3">
                        <button type="submit" 
                                class="w-full rounded-lg bg-zinc-900 px-6 py-3 text-sm font-medium text-white transition hover:bg-zinc-800 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-300">
                            Create Property Listing
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Filters -->
        <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
            <form method="GET" class="grid gap-3 md:grid-cols-5">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input name="search" value="{{ $search }}" placeholder="Search by title" 
                           class="w-full rounded-lg border border-zinc-300 py-2 pl-10 pr-3 dark:border-zinc-700 dark:bg-zinc-800">
                </div>
                <select name="status" class="rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800">
                    <option value="">All Status</option>
                    @foreach(['draft','pending','approved','rejected','sold','rented'] as $s)
                        <option value="{{ $s }}" @selected($status === $s)>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <select name="property_type" class="rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800">
                    <option value="">All Types</option>
                    @foreach(['house','apartment','land'] as $pt)
                        <option value="{{ $pt }}" @selected($type === $pt)>{{ ucfirst($pt) }}</option>
                    @endforeach
                </select>
                <select name="listing_type" class="rounded-lg border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-800">
                    <option value="">All Listings</option>
                    @foreach(['sale','rent'] as $lt)
                        <option value="{{ $lt }}" @selected($listingType === $lt)>{{ ucfirst($lt) }}</option>
                    @endforeach
                </select>
                <div class="flex gap-2">
                    <button class="flex-1 rounded-lg bg-zinc-900 px-4 py-2 text-white transition hover:bg-zinc-800 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-300">
                        Filter
                    </button>
                    <a href="{{ route('admin.properties.index') }}" 
                       class="inline-flex items-center rounded-lg border border-zinc-300 px-4 py-2 text-sm text-zinc-700 transition hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-800">
                        Clear
                    </a>
                </div>
            </form>
        </div>

        <!-- Properties Table -->
        <div class="overflow-hidden rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800">
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Property</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Agent</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Type</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Price</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse($properties as $property)
                            <tr class="transition hover:bg-zinc-50 dark:hover:bg-zinc-800">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        @if($property->primaryImage)
                                            <img src="{{ Storage::url($property->primaryImage->image_path) }}" 
                                                 alt="" class="h-10 w-10 rounded-lg object-cover">
                                        @else
                                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-zinc-200 dark:bg-zinc-700">
                                                <svg class="h-5 w-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-medium text-zinc-900 dark:text-white">{{ $property->title }}</div>
                                            <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ $property->city }}, {{ $property->state }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm">{{ $property->agent?->user?->name ?: '-' }}</div>
                                    <div class="text-xs text-zinc-500">{{ $property->agent?->user?->email ?: '' }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="rounded-full bg-zinc-100 px-2 py-1 text-xs dark:bg-zinc-800">
                                        {{ ucfirst($property->property_type) }}
                                    </span>
                                    <span class="ml-1 text-xs text-zinc-500">/ {{ ucfirst($property->listing_type) }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="font-medium">₦{{ number_format((float) $property->price) }}</div>
                                    <div class="text-xs text-zinc-500">{{ $property->price_unit }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                            'approved' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                            'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                            'draft' => 'bg-zinc-100 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-400',
                                            'sold' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
                                            'rented' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                        ];
                                    @endphp
                                    <span class="inline-flex rounded-full px-2 py-1 text-xs font-medium {{ $statusColors[$property->status] ?? 'bg-zinc-100' }}">
                                        {{ ucfirst($property->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-col gap-2">
                                        <a href="{{ route('admin.properties.show', $property) }}"
                                           class="inline-flex w-fit items-center justify-center rounded-lg border border-zinc-300 px-3 py-1.5 text-xs font-medium text-zinc-700 transition hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-300 dark:hover:bg-zinc-800">
                                            View Details
                                        </a>
                                        @if($property->status === 'pending')
                                            <div class="flex flex-wrap gap-2">
                                                <form method="POST" action="{{ route('admin.properties.approve', $property) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="rounded-lg bg-green-600 px-3 py-1.5 text-xs font-medium text-white transition hover:bg-green-700">
                                                        Approve
                                                    </button>
                                                </form>
                                                <button onclick="showRejectModal({{ $property->id }})" 
                                                        class="rounded-lg bg-red-600 px-3 py-1.5 text-xs font-medium text-white transition hover:bg-red-700">
                                                    Reject
                                                </button>
                                            </div>
                                        @endif
                                        @if($property->rejection_reason)
                                            <div class="text-xs text-red-600 dark:text-red-400">
                                                Reason: {{ $property->rejection_reason }}
                                            </div>
                                        @endif
                                        <form method="POST" action="{{ route('admin.properties.delete', $property) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this property? This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="rounded-lg bg-orange-600 px-3 py-1.5 text-xs font-medium text-white transition hover:bg-orange-700">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-zinc-500 dark:text-zinc-400">
                                    <svg class="mx-auto h-12 w-12 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    <p class="mt-2">No properties found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $properties->withQueryString()->links() }}
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">
        <div class="w-full max-w-md rounded-xl bg-white p-6 dark:bg-zinc-900">
            <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">Reject Property</h3>
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
                        Reject Property
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const propertyTypeFields = @json(\App\Models\Property::TYPE_DETAIL_FIELDS);

        function toggleAddProperty() {
            const form = document.getElementById('addPropertyForm');
            const icon = document.getElementById('toggleIcon');
            if (form.classList.contains('hidden')) {
                form.classList.remove('hidden');
                icon.classList.add('rotate-180');
            } else {
                form.classList.add('hidden');
                icon.classList.remove('rotate-180');
            }
        }

        function showRejectModal(propertyId) {
            document.getElementById('rejectModal').style.display = 'flex';
            const baseUrl = '{{ url("/admin/properties") }}';
            document.getElementById('rejectForm').action = baseUrl + '/' + propertyId + '/reject';
        }

        function hideRejectModal() {
            document.getElementById('rejectModal').style.display = 'none';
        }

        function updateAdminPropertyFields() {
            const typeSelect = document.getElementById('adminPropertyType');
            const selectedType = typeSelect?.value;
            const visibleFields = selectedType ? (propertyTypeFields[selectedType] || []) : [];

            document.querySelectorAll('[data-property-field]').forEach((wrapper) => {
                const field = wrapper.dataset.propertyField;
                const shouldShow = visibleFields.includes(field);

                wrapper.classList.toggle('hidden', ! shouldShow);
                wrapper.querySelectorAll('input, select, textarea').forEach((input) => {
                    input.disabled = ! shouldShow;
                });
            });
        }

        function updateAdminPriceUnit() {
            const listingType = document.getElementById('adminListingType');
            const priceUnit = document.getElementById('adminPriceUnit');

            if (! listingType || ! priceUnit || priceUnit.dataset.touched === '1') {
                return;
            }

            priceUnit.value = listingType.value === 'rent' ? 'per_year' : 'total';
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('adminPropertyType')?.addEventListener('change', updateAdminPropertyFields);
            document.getElementById('adminListingType')?.addEventListener('change', updateAdminPriceUnit);
            document.getElementById('adminPriceUnit')?.addEventListener('change', (event) => {
                event.currentTarget.dataset.touched = '1';
            });

            updateAdminPropertyFields();
            updateAdminPriceUnit();
        });
    </script>
</x-layouts::app>
