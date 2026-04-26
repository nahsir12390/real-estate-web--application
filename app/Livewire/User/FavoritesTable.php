<?php

namespace App\Livewire\User;

use App\Models\Favorite;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class FavoritesTable extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function removeFavorite($favoriteId): void
    {
        $favorite = Favorite::query()
            ->where('user_id', auth()->id())
            ->where('id', $favoriteId)
            ->firstOrFail();

        $favorite->delete();

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Property removed from favorites successfully.'
        ]);
    }

    public function render()
    {
        $userId = auth()->id();

        $favorites = Favorite::query()
            ->where('user_id', $userId)
            ->whereHas('property', function ($query) {
                if ($this->search !== '') {
                    $query->where('title', 'like', '%' . $this->search . '%');
                }
            })
            ->with(['property:id,title,slug,city,state,price,property_type,listing_type,status'])
            ->latest()
            ->paginate(10);

        return view('livewire.user.favorites-table', compact('favorites'));
    }
}