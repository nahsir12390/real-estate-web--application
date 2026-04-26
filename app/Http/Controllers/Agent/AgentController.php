<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AgentController extends Controller
{
    public function dashboard(): View
    {
        return view('agent.dashboard');
    }

    public function properties(): View
    {
        return view('agent.properties.index');
    }

    public function createProperty(): View
    {
        return view('agent.properties.create');
    }

    public function editProperty(Request $request, Property $property): View
    {
        $agentId = $request->user()->agent?->id;

        abort_unless($agentId && $property->agent_id === $agentId, 403);

        return view('agent.properties.edit', compact('property'));
    }

    public function inquiries(): View
    {
        return view('agent.inquiries');
    }

    public function subscription(): View
    {
        return view('agent.subscription');
    }

    public function verification(): View
    {
        return view('agent.verification');
    }
}
