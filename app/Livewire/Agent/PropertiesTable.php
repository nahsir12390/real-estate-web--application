<?php

namespace App\Livewire\Agent;

use App\Models\Property;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PropertiesTable extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $status = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $agentId = auth()->user()->agent?->id;

        $properties = Property::query()
            ->where('agent_id', $agentId)
            ->with('primaryImage:id,property_id,image_path,is_primary')
            ->search($this->search)
            ->byStatus($this->status ?: null)
            ->latest()
            ->paginate(10);

        return view('livewire.agent.properties-table', compact('properties'));
    }
}
