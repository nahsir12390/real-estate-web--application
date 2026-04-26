<?php

namespace Database\Seeders;

use App\Models\Agent;
use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoPropertiesSeeder extends Seeder
{
    public function run(): void
    {
        $proAgent = Agent::whereHas('user', fn ($query) => $query->where('email', 'proagent@realestate.ng'))->first();
        $freeAgent = Agent::whereHas('user', fn ($query) => $query->where('email', 'freeagent@realestate.ng'))->first();

        if ($proAgent) {
            $this->seedProperty(
                $proAgent->id,
                'Modern 3 Bedroom Apartment in Lekki Phase 1',
                'apartment',
                'rent',
                6500000.00,
                '15 Admiralty Way, Lekki Phase 1',
                'Lagos',
                'Lagos',
                'approved'
            );
        }

        if ($freeAgent) {
            $this->seedProperty(
                $freeAgent->id,
                'Affordable Land Plot Near Airport Road',
                'land',
                'sale',
                18000000.00,
                'Plot 14, Lugbe Extension',
                'Abuja',
                'FCT - Abuja',
                'pending'
            );
        }
    }

    private function seedProperty(
        int $agentId,
        string $title,
        string $propertyType,
        string $listingType,
        float $price,
        string $address,
        string $city,
        string $state,
        string $status
    ): void {
        $slug = Str::slug($title);

        $property = Property::updateOrCreate(
            ['slug' => $slug],
            [
                'agent_id' => $agentId,
                'title' => $title,
                'description' => 'Demo Nigerian property listing generated for local development and UI testing.',
                'property_type' => $propertyType,
                'listing_type' => $listingType,
                'price' => $price,
                'address' => $address,
                'city' => $city,
                'state' => $state,
                'country' => 'Nigeria',
                'status' => $status,
                'published_at' => now(),
            ]
        );

        PropertyImage::updateOrCreate(
            [
                'property_id' => $property->id,
                'image_path' => 'properties/demo-placeholder.jpg',
            ],
            [
                'is_primary' => true,
                'order' => 1,
                'alt_text' => $title,
            ]
        );
    }
}
