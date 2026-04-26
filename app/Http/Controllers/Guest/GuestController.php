<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GuestController extends Controller
{
    public function home(Request $request): View|RedirectResponse
    {
        if ($request->user()) {
            return redirect()->route('dashboard');
        }

        $properties = Property::query()
            ->approved()
            ->with([
                'primaryImage:id,property_id,image_path,is_primary',
                'agent:id,user_id,company_name',
                'agent.user:id,name,email',
            ])
            ->latest()
            ->take(8)
            ->get();

        return view('guest.home', compact('properties'));
    }

    public function properties(Request $request): View|RedirectResponse
    {
        if ($request->user()) {
            return redirect()->route('dashboard');
        }

        $search = $request->string('search')->toString();

        $properties = Property::query()
            ->approved()
            ->search($search)
            ->with([
                'primaryImage:id,property_id,image_path,is_primary',
                'agent:id,user_id,company_name',
                'agent.user:id,name,email',
            ])
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('guest.properties.index', compact('properties', 'search'));
    }

    public function showProperty(Request $request, string $slug): View|RedirectResponse
    {
        if ($request->user()) {
            return redirect()->route('dashboard');
        }

        $property = Property::query()
            ->approved()
            ->where('slug', $slug)
            ->with([
                'images:id,property_id,image_path,is_primary,order',
                'agent:id,user_id,company_name,specialization,experience_years',
                'agent.user:id,name,email',
                'agent.user.profile:id,user_id,phone,whatsapp_number',
            ])
            ->firstOrFail();

        return view('guest.properties.show', compact('property'));
    }
}
