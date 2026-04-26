<?php

namespace App\Livewire\Agent;

use App\Models\Inquiry;
use App\Models\Property;
use App\Models\AgentVerification;
use App\Models\Subscription;
use App\Services\AgentListingQuotaService;
use Livewire\Component;

class DashboardStats extends Component
{
    public array $quota = [];

    public function mount(): void
    {
        $this->quota = app(AgentListingQuotaService::class)->quotaSummary(auth()->user());
    }

    public function render()
    {
        $user = auth()->user();
        $agent = $user->agent;
        $agentId = $agent?->id;

        // Check verification status
        $verificationStatus = [
            'needs_verification' => true,
            'has_submitted' => false,
            'status' => null,
            'latest_submission' => null,
            'message' => '',
            'warning_type' => 'not_submitted',
        ];

        if ($agent) {
            $latestVerification = AgentVerification::query()
                ->where('agent_id', $agentId)
                ->latest()
                ->first();

            if ($latestVerification) {
                $verificationStatus['has_submitted'] = true;
                $verificationStatus['latest_submission'] = $latestVerification;
                $verificationStatus['status'] = $latestVerification->status;
                
                if ($latestVerification->status === AgentVerification::STATUS_PENDING) {
                    $verificationStatus['needs_verification'] = false;
                    $verificationStatus['warning_type'] = 'pending';
                    $verificationStatus['message'] = 'Your verification is pending review. You cannot list properties until approved.';
                } elseif ($latestVerification->status === AgentVerification::STATUS_APPROVED) {
                    $verificationStatus['needs_verification'] = false;
                    $verificationStatus['warning_type'] = 'approved';
                    $verificationStatus['message'] = 'Your account is verified. You can now list properties.';
                } elseif ($latestVerification->status === AgentVerification::STATUS_REJECTED) {
                    $verificationStatus['needs_verification'] = true;
                    $verificationStatus['warning_type'] = 'rejected';
                    $verificationStatus['message'] = 'Your verification was rejected. Please submit new documents.';
                }
            } else {
                $verificationStatus['message'] = 'You have not submitted any verification documents yet. You must verify your account to list properties.';
            }
        }

        $hasActiveSubscription = false;
        $subscriptionNotice = null;

        if ($agentId) {
            $hasActiveSubscription = Subscription::query()
                ->where('agent_id', $agentId)
                ->active()
                ->exists();

            if (! $hasActiveSubscription) {
                $freeSlotAvailable = (bool) ($this->quota['free_sale_slot_available'] ?? false);
                $remaining = (int) ($this->quota['remaining_slots'] ?? 0);

                $subscriptionNotice = [
                    'show' => true,
                    'free_slot_available' => $freeSlotAvailable,
                    'message' => $freeSlotAvailable
                        ? "You don't have an active subscription yet. You can still post {$remaining} free sale listing, then subscribe for more."
                        : "You don't have an active subscription. Subscribe to a plan to continue posting properties.",
                ];
            }
        }

        $stats = [
            'total_properties' => Property::query()->where('agent_id', $agentId)->count(),
            'pending_properties' => Property::query()->where('agent_id', $agentId)->where('status', Property::STATUS_PENDING)->count(),
            'approved_properties' => Property::query()->where('agent_id', $agentId)->where('status', Property::STATUS_APPROVED)->count(),
            'new_inquiries' => Inquiry::query()->where('agent_id', $agentId)->where('status', Inquiry::STATUS_NEW)->count(),
        ];

        return view('livewire.agent.dashboard-stats', compact('stats', 'verificationStatus', 'hasActiveSubscription', 'subscriptionNotice'));
    }
}
