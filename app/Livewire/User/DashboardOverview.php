<?php

namespace App\Livewire\User;

use App\Models\Favorite;
use App\Models\Inquiry;
use App\Models\Property;
use App\Models\Report;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class DashboardOverview extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';
    public array $favoritePropertyIds = [];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function toggleFavorite(int $propertyId): void
    {
        $userId = auth()->id();

        $propertyExists = Property::query()
            ->approved()
            ->whereKey($propertyId)
            ->exists();

        if (! $propertyExists) {
            return;
        }

        $favorite = Favorite::query()
            ->where('user_id', $userId)
            ->where('property_id', $propertyId)
            ->first();

        if ($favorite) {
            $favorite->delete();
            session()->flash('favorite_status', 'Property removed from favorites.');
        } else {
            Favorite::create([
                'user_id' => $userId,
                'property_id' => $propertyId,
            ]);
            session()->flash('favorite_status', 'Property added to favorites.');
        }
    }

    public function render()
    {
        $user = auth()->user();

        $stats = [
            'favorites' => Favorite::query()->where('user_id', $user->id)->count(),
            'inquiries' => Inquiry::query()->where('user_id', $user->id)->count(),
            'reports' => Report::query()->where('user_id', $user->id)->count(),
            'profile_complete' => $user->profile()->exists(),
        ];

        $marketplaceProperties = Property::query()
            ->approved()
            ->when($this->search !== '', fn ($query) => $query->search($this->search))
            ->with([
                'primaryImage:id,property_id,image_path,is_primary',
                'agent:id,user_id,company_name,experience_years,specialization',
                'agent.user:id,name,email',
                'agent.user.profile:id,user_id,phone,whatsapp_number',
            ])
            ->latest()
            ->paginate(12);

        $this->favoritePropertyIds = Favorite::query()
            ->where('user_id', $user->id)
            ->whereIn('property_id', $marketplaceProperties->getCollection()->pluck('id'))
            ->pluck('property_id')
            ->map(fn ($id) => (int) $id)
            ->all();

        return view('livewire.user.dashboard-overview', compact('stats', 'marketplaceProperties'));
    }
}
