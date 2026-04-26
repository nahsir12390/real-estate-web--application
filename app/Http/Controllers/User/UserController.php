<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\View\View;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function home(): View
    {
        return view('user.home');
    }

    public function favorites(): View
    {
        return view('user.favorites');
    }

    public function inquiries(): View
    {
        return view('user.inquiries');
    }

    public function reports(): View
    {
        return view('user.reports');
    }

    public function showProperty(Request $request, string $slug): View
    {
        $property = Property::query()
            ->where('slug', $slug)
            ->approved()
            ->firstOrFail();

        return view('user.properties.show', compact('property'));
    }
}
