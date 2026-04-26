<?php

namespace App\Livewire\Agent;

use App\Models\Inquiry;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class InquiriesTable extends Component
{
    use WithPagination;

    #[Url]
    public string $status = '';
    public array $replyDrafts = [];

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function markAs(int $inquiryId, string $status): void
    {
        abort_unless(in_array($status, [Inquiry::STATUS_NEW, Inquiry::STATUS_CONTACTED, Inquiry::STATUS_CLOSED], true), 422);

        $inquiry = Inquiry::query()
            ->where('id', $inquiryId)
            ->where('agent_id', auth()->user()->agent?->id)
            ->firstOrFail();

        $allowedTransitions = [
            Inquiry::STATUS_NEW => [Inquiry::STATUS_CONTACTED, Inquiry::STATUS_CLOSED],
            Inquiry::STATUS_CONTACTED => [Inquiry::STATUS_CLOSED],
            Inquiry::STATUS_CLOSED => [],
        ];

        if (! in_array($status, $allowedTransitions[$inquiry->status] ?? [], true)) {
            return;
        }

        $inquiry->update([
            'status' => $status,
            'responded_at' => in_array($status, [Inquiry::STATUS_CONTACTED, Inquiry::STATUS_CLOSED], true) ? now() : null,
        ]);

        session()->flash('status', 'Inquiry status updated.');
    }

    public function sendReply(int $inquiryId): void
    {
        $reply = trim((string) ($this->replyDrafts[$inquiryId] ?? ''));

        if ($reply === '') {
            $this->addError("replyDrafts.{$inquiryId}", 'Reply message is required.');

            return;
        }

        $inquiry = Inquiry::query()
            ->where('id', $inquiryId)
            ->where('agent_id', auth()->user()->agent?->id)
            ->firstOrFail();

        $inquiry->update([
            'agent_reply' => $reply,
            'agent_replied_at' => now(),
            'status' => Inquiry::STATUS_CONTACTED,
            'responded_at' => now(),
        ]);

        $this->replyDrafts[$inquiryId] = '';
        session()->flash('status', 'Reply sent to user successfully.');
    }

    public function render()
    {
        $agentId = auth()->user()->agent?->id;

        $inquiries = Inquiry::query()
            ->where('agent_id', $agentId)
            ->with(['property:id,title,city,state', 'user:id,name,email'])
            ->byStatus($this->status ?: null)
            ->latest()
            ->paginate(10);

        return view('livewire.agent.inquiries-table', compact('inquiries'));
    }
}
