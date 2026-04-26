<?php

namespace App\Livewire\Agent;

use App\Models\AgentVerification;
use Livewire\Component;
use Livewire\WithFileUploads;

class VerificationStatus extends Component
{
    use WithFileUploads;

    public $id_front_image;
    public $id_back_image;
    public $selfie_image;
    public $license_image;

    public function submit(): void
    {
        $validated = $this->validate([
            'id_front_image' => ['required', 'image', 'max:4096'],
            'id_back_image' => ['nullable', 'image', 'max:4096'],
            'selfie_image' => ['required', 'image', 'max:4096'],
            'license_image' => ['nullable', 'image', 'max:4096'],
        ]);

        $agent = auth()->user()->agent;
        abort_unless($agent, 403);

        AgentVerification::create([
            'agent_id' => $agent->id,
            'id_front_image' => $validated['id_front_image']->store('verifications', 'public'),
            'id_back_image' => $validated['id_back_image'] ? $validated['id_back_image']->store('verifications', 'public') : null,
            'selfie_image' => $validated['selfie_image']->store('verifications', 'public'),
            'license_image' => $validated['license_image'] ? $validated['license_image']->store('verifications', 'public') : null,
            'status' => AgentVerification::STATUS_PENDING,
        ]);

        $agent->update([
            'verification_status' => \App\Models\Agent::STATUS_PENDING,
            'verified_at' => null,
            'rejection_reason' => null,
        ]);

        $this->reset(['id_front_image', 'id_back_image', 'selfie_image', 'license_image']);
        session()->flash('status', 'Verification request submitted.');
    }

    public function render()
    {
        $agent = auth()->user()->agent;

        $latest = AgentVerification::query()
            ->where('agent_id', $agent?->id)
            ->latest()
            ->first();

        return view('livewire.agent.verification-status', compact('agent', 'latest'));
    }
}
