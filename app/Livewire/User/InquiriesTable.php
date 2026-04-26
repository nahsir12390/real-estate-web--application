<?php

namespace App\Livewire\User;

use App\Models\Inquiry;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class InquiriesTable extends Component
{
    use WithPagination;

    #[Url]
    public string $status = '';

    public $selectedInquiry = null;

    protected $listeners = ['refreshInquiries' => '$refresh'];

    public function updatingStatus(): void
    {
        $this->resetPage();
        $this->selectedInquiry = null;
    }

    public function viewInquiry($inquiryId): void
    {
        $this->selectedInquiry = Inquiry::query()
            ->where('user_id', auth()->id())
            ->with([
                'property:id,title,city,state',
                'agent:id,user_id',
                'agent.user:id,name,email',
            ])
            ->findOrFail($inquiryId);
    }

    public function closeModal(): void
    {
        $this->selectedInquiry = null;
    }

    public function render()
    {
        $inquiries = Inquiry::query()
            ->where('user_id', auth()->id())
            ->when($this->status !== '', fn ($query) => $query->where('status', $this->status))
            ->with([
                'property:id,title,city,state',
                'agent:id,user_id',
                'agent.user:id,name,email',
            ])
            ->latest()
            ->paginate(10);

        return view('livewire.user.inquiries-table', compact('inquiries'));
    }
}