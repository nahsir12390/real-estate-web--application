<?php

namespace App\Livewire\User;

use App\Models\Report;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ReportsTable extends Component
{
    use WithPagination;

    #[Url]
    public string $status = '';

    public $selectedReport = null;

    protected $listeners = ['refreshReports' => '$refresh'];

    public function updatingStatus(): void
    {
        $this->resetPage();
        $this->selectedReport = null;
    }

    public function viewReport($reportId): void
    {
        $this->selectedReport = Report::query()
            ->where('user_id', auth()->id())
            ->with(['property:id,title'])
            ->findOrFail($reportId);
    }

    public function cancelReport($reportId): void
    {
        $report = Report::query()
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->findOrFail($reportId);

        $report->update([
            'status' => 'dismissed',
            'admin_notes' => 'Cancelled by user',
        ]);

        $this->selectedReport = null;
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Report cancelled successfully.'
        ]);
    }

    public function render()
    {
        $reports = Report::query()
            ->where('user_id', auth()->id())
            ->when($this->status !== '', fn ($query) => $query->where('status', $this->status))
            ->with('property:id,title')
            ->latest()
            ->paginate(10);

        return view('livewire.user.reports-table', compact('reports'));
    }
}