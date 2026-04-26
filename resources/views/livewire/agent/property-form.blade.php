<div class="space-y-4">
    <!-- Navigation Button -->
    <div class="flex justify-end">
        <a href="{{ route('agent.dashboard') }}"
           class="inline-flex items-center rounded-md bg-zinc-900 px-3 py-1.5 text-sm font-medium text-white hover:bg-zinc-700 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-300">
            <svg class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Dashboard
        </a>
    </div>

    @if (session('status'))
        <div class="rounded border border-green-300 bg-green-50 p-3 text-sm text-green-700">{{ session('status') }}</div>
    @endif

    <form wire:submit="save" class="grid gap-3 md:grid-cols-3">
        <input wire:model="title" placeholder="Title" class="rounded border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-900 md:col-span-2">
        <select wire:model="property_type" class="rounded border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-900">
            <option value="house">House</option>
            <option value="apartment">Apartment</option>
            <option value="land">Land</option>
        </select>
        <input wire:model="short_description" placeholder="Short description" class="rounded border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-900 md:col-span-3">
        <textarea wire:model="description" rows="4" placeholder="Description" class="rounded border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-900 md:col-span-3"></textarea>

        <select wire:model="listing_type" class="rounded border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-900">
            <option value="sale">For Sale</option>
            <option value="rent">For Rent</option>
        </select>
        @php($hasActiveSubscription = (bool) auth()->user()?->agent?->activeSubscription()->exists())
        @unless($hasActiveSubscription)
            <p class="text-xs text-zinc-500 md:col-span-3">On free allowance, only one <strong>For Sale</strong> listing is available. <strong>For Rent</strong> requires a subscription.</p>
        @endunless
        <input wire:model="price" type="number" step="0.01" placeholder="Price" class="rounded border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-900">
        <select wire:model="price_unit" class="rounded border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-900">
            <option value="total">Total</option>
            <option value="per_month">Per Month</option>
            <option value="per_year">Per Year</option>
        </select>

        <input wire:model="area" type="number" step="0.01" placeholder="Area" class="rounded border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-900">
        <select wire:model="area_unit" class="rounded border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-900">
            <option value="sqm">sqm</option>
            <option value="sqft">sqft</option>
        </select>
        <input wire:model="year_built" type="number" placeholder="Year built" class="rounded border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-900">

        <input wire:model="bedrooms" type="number" placeholder="Bedrooms" class="rounded border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-900">
        <input wire:model="bathrooms" type="number" placeholder="Bathrooms" class="rounded border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-900">
        <input wire:model="garages" type="number" placeholder="Garages" class="rounded border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-900">

        <input wire:model="address" placeholder="Address" class="rounded border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-900 md:col-span-2">
        <input wire:model="city" placeholder="City" class="rounded border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-900">
        <input wire:model="state" placeholder="State" class="rounded border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-900">
        <input wire:model="zip_code" placeholder="Zip code" class="rounded border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-900">
        <input wire:model="country" placeholder="Country" class="rounded border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-900">

        <div>
            <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Latitude <span class="text-xs text-zinc-500">(Optional)</span></label>
            <input wire:model="latitude" type="number" step="0.00000001" placeholder="e.g., 6.5244" class="w-full rounded border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-900">
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Longitude <span class="text-xs text-zinc-500">(Optional)</span></label>
            <input wire:model="longitude" type="number" step="0.00000001" placeholder="e.g., 3.3792" class="w-full rounded border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-900">
        </div>
        <input wire:model="amenities" placeholder="Amenities (comma separated)" class="rounded border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-900 md:col-span-3">

        <!-- Image Upload -->
        <div class="md:col-span-3">
            <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Property Images</label>
            <input wire:model="images" type="file" multiple accept="image/*" class="w-full rounded border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-900">
            <p class="mt-1 text-xs text-zinc-500">You can upload multiple images. The first image will be set as the primary image.</p>
        </div>

        @if ($propertyId && count($existingImages) > 0)
            <div class="md:col-span-3">
                <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Existing Images</label>
                <div class="grid gap-3 sm:grid-cols-2 md:grid-cols-4">
                    @foreach ($existingImages as $image)
                        <div class="relative overflow-hidden rounded-lg border border-zinc-300 dark:border-zinc-700">
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($image['image_path']) }}" alt="Existing property image" class="h-40 w-full object-cover">
                            @if ($image['is_primary'])
                                <div class="absolute top-2 left-2 rounded-full bg-blue-600 px-2 py-1 text-xs font-medium text-white">
                                    Primary
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Image Preview Gallery -->
        @if (count($images) > 0)
            <div class="md:col-span-3">
                <label class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Image Preview</label>
                <div class="grid gap-3 sm:grid-cols-2 md:grid-cols-4">
                    @foreach ($images as $index => $image)
                        <div class="group relative overflow-hidden rounded-lg border border-zinc-300 dark:border-zinc-700">
                            <img src="{{ $image->temporaryUrl() }}" alt="Preview {{ $index + 1 }}" 
                                 class="h-40 w-full object-cover">
                            <div class="absolute inset-0 bg-black/0 transition group-hover:bg-black/30"></div>
                            @if ($index === 0)
                                <div class="absolute top-2 left-2 rounded-full bg-blue-600 px-2 py-1 text-xs font-medium text-white">
                                    Primary
                                </div>
                            @endif
                            <button wire:click="$set('images', array_values(array_diff($images, [$image])))" type="button"
                                    class="absolute bottom-2 right-2 rounded bg-red-600 p-2 text-white opacity-0 transition group-hover:opacity-100">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @error('*')
            <p class="text-sm text-red-600 md:col-span-3">{{ $message }}</p>
        @enderror

        <div class="md:col-span-3">
            <button class="rounded bg-zinc-900 px-4 py-2 text-white dark:bg-zinc-100 dark:text-zinc-900">
                {{ $propertyId ? 'Update Property' : 'Create Property' }}
            </button>
        </div>
    </form>
</div>
