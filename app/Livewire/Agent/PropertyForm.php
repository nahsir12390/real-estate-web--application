<?php

namespace App\Livewire\Agent;

use App\Models\Property;
use App\Models\PropertyImage;
use App\Services\AgentListingQuotaService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class PropertyForm extends Component
{
    use WithFileUploads;

    public ?int $propertyId = null;

    public string $title = '';
    public string $description = '';
    public ?string $short_description = null;
    public string $property_type = 'house';
    public string $listing_type = 'sale';
    public string $price = '';
    public string $price_unit = 'total';
    public ?string $area = null;
    public string $area_unit = 'sqm';
    public ?int $bedrooms = null;
    public ?int $bathrooms = null;
    public ?int $garages = null;
    public ?int $year_built = null;
    public string $address = '';
    public string $city = '';
    public string $state = '';
    public string $zip_code = '';
    public string $country = 'Nigeria';
    public ?string $latitude = null;
    public ?string $longitude = null;
    public string $amenities = '';
    public array $images = [];
    public array $existingImages = [];

    public function mount(?int $propertyId = null): void
    {
        if (! $propertyId) {
            return;
        }

        $property = Property::query()
            ->with('images')
            ->where('id', $propertyId)
            ->where('agent_id', auth()->user()->agent?->id)
            ->firstOrFail();

        $this->propertyId = $property->id;
        $this->title = $property->title;
        $this->description = $property->description;
        $this->short_description = $property->short_description;
        $this->property_type = $property->property_type;
        $this->listing_type = $property->listing_type;
        $this->price = (string) $property->price;
        $this->price_unit = $property->price_unit ?: 'total';
        $this->area = $property->area ? (string) $property->area : null;
        $this->area_unit = $property->area_unit ?: 'sqm';
        $this->bedrooms = $property->bedrooms;
        $this->bathrooms = $property->bathrooms;
        $this->garages = $property->garages;
        $this->year_built = $property->year_built;
        $this->address = $property->address;
        $this->city = $property->city;
        $this->state = $property->state;
        $this->zip_code = (string) $property->zip_code;
        $this->country = (string) ($property->country ?: 'Nigeria');
        $this->latitude = $property->latitude ? (string) $property->latitude : null;
        $this->longitude = $property->longitude ? (string) $property->longitude : null;
        $this->amenities = is_array($property->amenities) ? implode(', ', $property->amenities) : '';
        $this->existingImages = $property->images
            ->sortBy('order')
            ->map(fn (PropertyImage $image) => [
                'id' => $image->id,
                'image_path' => $image->image_path,
                'is_primary' => (bool) $image->is_primary,
            ])
            ->values()
            ->all();
    }

    public function save(): void
    {
        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'property_type' => ['required', 'in:house,apartment,land'],
            'listing_type' => ['required', 'in:sale,rent'],
            'price' => ['required', 'numeric', 'min:0'],
            'price_unit' => ['nullable', 'string', 'max:20'],
            'area' => ['nullable', 'numeric', 'min:0'],
            'area_unit' => ['nullable', 'string', 'max:20'],
            'bedrooms' => ['nullable', 'integer', 'min:0'],
            'bathrooms' => ['nullable', 'integer', 'min:0'],
            'garages' => ['nullable', 'integer', 'min:0'],
            'year_built' => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'zip_code' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:100'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'amenities' => ['nullable', 'string'],
            'images.*' => ['nullable', 'image', 'max:4096'],
        ]);

        $agentId = auth()->user()->agent?->id;
        abort_unless($agentId, 403);

        if (! $this->propertyId) {
            try {
                app(AgentListingQuotaService::class)->authorizeOrFail(auth()->user(), $validated['listing_type']);
            } catch (AuthorizationException $exception) {
                $this->addError('title', $exception->getMessage());

                return;
            }
        }

        $payload = [
            'agent_id' => $agentId,
            'title' => $validated['title'],
            'slug' => $this->propertyId ? Property::find($this->propertyId)->slug : $this->generateSlug($validated['title']),
            'description' => $validated['description'],
            'short_description' => $validated['short_description'] ?? null,
            'property_type' => $validated['property_type'],
            'listing_type' => $validated['listing_type'],
            'price' => $validated['price'],
            'price_unit' => $validated['price_unit'] ?? 'total',
            'area' => $this->nullableNumber($validated['area'] ?? null),
            'area_unit' => $validated['area_unit'] ?? 'sqm',
            'bedrooms' => $validated['bedrooms'] ?? null,
            'bathrooms' => $validated['bathrooms'] ?? null,
            'garages' => $validated['garages'] ?? null,
            'year_built' => $validated['year_built'] ?? null,
            'address' => $validated['address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'zip_code' => $validated['zip_code'] ?? null,
            'country' => $validated['country'] ?? 'Nigeria',
            'latitude' => $this->nullableNumber($validated['latitude'] ?? null),
            'longitude' => $this->nullableNumber($validated['longitude'] ?? null),
            'amenities' => $this->parseAmenities($validated['amenities'] ?? null),
            'status' => Property::STATUS_PENDING,
            'rejection_reason' => null,
        ];

        if ($this->propertyId) {
            $property = Property::query()
                ->where('id', $this->propertyId)
                ->where('agent_id', $agentId)
                ->firstOrFail();

            $property->update($payload);
        } else {
            $property = Property::create($payload);
            $this->propertyId = $property->id;
        }

        $this->storeUploadedImages($property);

        session()->flash('status', 'Property saved successfully.');
        $this->redirectRoute('agent.properties.index', navigate: true);
    }

    private function storeUploadedImages(Property $property): void
    {
        if ($this->images === []) {
            return;
        }

        $order = (int) PropertyImage::query()->where('property_id', $property->id)->max('order');
        $hasPrimary = PropertyImage::query()->where('property_id', $property->id)->where('is_primary', true)->exists();

        foreach ($this->images as $image) {
            $path = $image->store('properties', 'public');
            $order++;

            PropertyImage::create([
                'property_id' => $property->id,
                'image_path' => $path,
                'is_primary' => ! $hasPrimary,
                'order' => $order,
                'alt_text' => $property->title,
            ]);

            $hasPrimary = true;
        }

        $this->images = [];
    }

    private function parseAmenities(?string $amenities): ?array
    {
        if (! $amenities) {
            return null;
        }

        return collect(explode(',', $amenities))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();
    }

    private function nullableNumber(mixed $value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        return (float) $value;
    }

    private function generateSlug(string $title): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $counter = 1;

        while (Property::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    public function render()
    {
        return view('livewire.agent.property-form');
    }
}
