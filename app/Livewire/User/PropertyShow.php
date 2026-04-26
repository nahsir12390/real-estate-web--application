<?php

namespace App\Livewire\User;

use App\Models\Inquiry;
use App\Models\Property;
use App\Models\PropertyComment;
use Livewire\Component;

class PropertyShow extends Component
{
    public int $propertyId;
    public string $comment = '';
    public string $message = '';
    public ?string $phone = null;
    public string $preferred_contact = 'email';

    public function mount(int $propertyId): void
    {
        $this->propertyId = $propertyId;
    }

    public function addComment(): void
    {
        $this->validate([
            'comment' => ['required', 'string', 'min:2', 'max:2000'],
        ]);

        $property = $this->approvedProperty();

        PropertyComment::create([
            'property_id' => $property->id,
            'user_id' => auth()->id(),
            'comment' => trim($this->comment),
        ]);

        $this->comment = '';
        $this->dispatch('notify', type: 'success', message: 'Comment posted.');
    }

    public function sendInquiry(): void
    {
        $this->validate([
            'message' => ['required', 'string', 'min:5', 'max:5000'],
            'phone' => ['nullable', 'string', 'max:20'],
            'preferred_contact' => ['required', 'in:email,phone,whatsapp'],
        ]);

        $property = $this->approvedProperty();
        $user = auth()->user();

        Inquiry::create([
            'user_id' => $user->id,
            'property_id' => $property->id,
            'agent_id' => $property->agent_id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $this->phone ?: $user->profile?->phone,
            'message' => trim($this->message),
            'preferred_contact' => $this->preferred_contact,
            'status' => Inquiry::STATUS_NEW,
        ]);

        $this->reset(['message', 'phone']);
        $this->preferred_contact = 'email';
        session()->flash('inquiry_status', 'Inquiry sent successfully. The agent will contact you soon.');
        $this->dispatch('notify', type: 'success', message: 'Inquiry sent to agent.');
    }

    public function render()
    {
        $property = $this->approvedProperty();
        $comments = $property->comments()->with('user:id,name')->latest()->get();

        return view('livewire.user.property-show', compact('property', 'comments'));
    }

    private function approvedProperty(): Property
    {
        return Property::query()
            ->where('id', $this->propertyId)
            ->approved()
            ->with([
                'images:id,property_id,image_path,is_primary,order',
                'agent:id,user_id,company_name,experience_years,specialization',
                'agent.user:id,name,email',
                'agent.user.profile:id,user_id,phone,whatsapp_number',
            ])
            ->firstOrFail();
    }
}
