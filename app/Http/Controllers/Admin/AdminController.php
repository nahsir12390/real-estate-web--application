<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\AgentVerification;
use App\Models\Inquiry;
use App\Models\Plan;
use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\Report;
use App\Models\Setting;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminController extends Controller
{
    use AuthorizesRequests;

    private const PER_PAGE = 15;

    public function dashboard(): View
    {
        $stats = Cache::remember('admin:dashboard:stats', now()->addSeconds(30), function () {
            return [
                'users' => User::count(),
                'agents_pending' => Agent::query()->byVerificationStatus(Agent::STATUS_PENDING)->count(),
                'properties_pending' => Property::query()->byStatus(Property::STATUS_PENDING)->count(),
                'active_subscriptions' => Subscription::query()->active()->count(),
                'open_reports' => Report::query()->whereIn('status', [Report::STATUS_PENDING, Report::STATUS_REVIEWED])->count(),
                'new_inquiries' => Inquiry::query()->byStatus(Inquiry::STATUS_NEW)->count(),
            ];
        });

        return view('admin.dashboard', [
            'stats' => $stats,
        ]);
    }

    public function agents(Request $request): View
    {
        $status = $request->string('status')->toString();
        $search = $request->string('search')->toString();

        $agents = Agent::query()
            ->select(['id', 'user_id', 'company_name', 'verification_status', 'verified_at', 'rejection_reason', 'created_at'])
            ->with([
                'user:id,name,email',
                'verifications:id,agent_id,status,created_at',
            ])
            ->byVerificationStatus($status)
            ->search($search)
            ->latest()
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        return view('admin.agents.index', compact('agents', 'status', 'search'));
    }

    public function verifications(Request $request): View
    {
        $status = $request->string('status')->toString();
        $search = $request->string('search')->toString();

        $verifications = AgentVerification::query()
            ->select([
                'id',
                'agent_id',
                'id_front_image',
                'id_back_image',
                'selfie_image',
                'license_image',
                'status',
                'admin_notes',
                'reviewed_by',
                'reviewed_at',
                'created_at',
            ])
            ->with([
                'agent:id,user_id',
                'agent.user:id,name,email',
                'reviewer:id,name,email',
            ])
            ->byStatus($status)
            ->search($search)
            ->latest()
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        return view('admin.verifications.index', compact('verifications', 'status', 'search'));
    }

    public function approveVerification(Request $request, AgentVerification $agentVerification): RedirectResponse
    {
        $validated = $request->validate([
            'admin_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $agentVerification->update([
            'status' => AgentVerification::STATUS_APPROVED,
            'admin_notes' => $validated['admin_notes'] ?? null,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        $agentVerification->agent->update([
            'verification_status' => Agent::STATUS_VERIFIED,
            'verified_at' => now(),
            'rejection_reason' => null,
        ]);

        $agentVerification->agent->user()->update([
            'role' => User::ROLE_AGENT,
        ]);

        Cache::forget('admin:dashboard:stats');

        return back()->with('status', 'Verification approved and agent marked as verified.');
    }

    public function rejectVerification(Request $request, AgentVerification $agentVerification): RedirectResponse
    {
        $validated = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:1000'],
            'admin_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $agentVerification->update([
            'status' => AgentVerification::STATUS_REJECTED,
            'admin_notes' => trim($validated['rejection_reason'].' | '.($validated['admin_notes'] ?? '')),
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        $agentVerification->agent->update([
            'verification_status' => Agent::STATUS_REJECTED,
            'verified_at' => null,
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        Cache::forget('admin:dashboard:stats');

        return back()->with('status', 'Verification rejected.');
    }

    public function approveAgent(Agent $agent): RedirectResponse
    {
        $agent->update([
            'verification_status' => Agent::STATUS_VERIFIED,
            'verified_at' => now(),
            'rejection_reason' => null,
        ]);

        $agent->user()->update(['role' => User::ROLE_AGENT]);

        Cache::forget('admin:dashboard:stats');

        return back()->with('status', 'Agent approved successfully.');
    }

    public function rejectAgent(Request $request, Agent $agent): RedirectResponse
    {
        $validated = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:1000'],
        ]);

        $agent->update([
            'verification_status' => Agent::STATUS_REJECTED,
            'verified_at' => null,
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        Cache::forget('admin:dashboard:stats');

        return back()->with('status', 'Agent rejected.');
    }

    public function properties(Request $request): View
    {
        $status = $request->string('status')->toString();
        $type = $request->string('property_type')->toString();
        $listingType = $request->string('listing_type')->toString();
        $search = $request->string('search')->toString();

        $properties = Property::query()
            ->select([
                'id', 'agent_id', 'title', 'property_type', 'listing_type', 'price',
                'city', 'state', 'country', 'status', 'approved_by', 'rejection_reason', 'created_at',
            ])
            ->with([
                'agent:id,user_id',
                'agent.user:id,name,email',
                'primaryImage:id,property_id,image_path,is_primary',
            ])
            ->byStatus($status)
            ->byType($type)
            ->byListingType($listingType)
            ->search($search)
            ->latest()
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        $verifiedAgents = Agent::query()
            ->select(['id', 'user_id'])
            ->verified()
            ->with('user:id,name,email')
            ->get();

        $nigerianStates = $this->nigerianStates();

        return view('admin.properties.index', compact('properties', 'status', 'type', 'listingType', 'search', 'verifiedAgents', 'nigerianStates'));
    }

    public function showProperty(Property $property): View
    {
        $property->load([
            'agent.user.profile',
            'approver:id,name,email',
            'images' => fn ($query) => $query->ordered(),
        ]);

        return view('admin.properties.show', compact('property'));
    }

    public function storeProperty(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'agent_id' => ['required', 'exists:agents,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'property_type' => ['required', Rule::in(array_keys(Property::PROPERTY_TYPES))],
            'listing_type' => ['required', Rule::in(array_keys(Property::LISTING_TYPES))],
            'price' => ['required', 'numeric', 'min:0'],
            'price_unit' => ['nullable', Rule::in(array_keys(Property::PRICE_UNITS))],
            'area' => ['nullable', 'numeric', 'min:0'],
            'area_unit' => ['nullable', Rule::in(array_keys(Property::AREA_UNITS))],
            'bedrooms' => ['nullable', 'integer', 'min:0'],
            'bathrooms' => ['nullable', 'integer', 'min:0'],
            'garages' => ['nullable', 'integer', 'min:0'],
            'year_built' => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'country' => ['nullable', 'string', 'max:100'],
            'zip_code' => ['nullable', 'string', 'max:20'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'amenities' => ['nullable', 'string'],
            'is_featured' => ['nullable', 'boolean'],
            'is_premium' => ['nullable', 'boolean'],
            'status' => ['nullable', 'in:draft,pending,approved'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:4096'],
        ]);

        $agent = Agent::findOrFail((int) $validated['agent_id']);

        if (! $agent->isVerified()) {
            return back()->withErrors(['agent_id' => 'Selected agent must be verified.'])->withInput();
        }

        $payload = $this->normalizePropertyPayload($validated);
        $status = $validated['status'] ?? Property::STATUS_APPROVED;

        $property = Property::create([
            'agent_id' => $agent->id,
            'title' => $validated['title'],
            'slug' => $this->generatePropertySlug($validated['title']),
            'description' => $payload['description'],
            'short_description' => $validated['short_description'] ?? null,
            'property_type' => $validated['property_type'],
            'listing_type' => $validated['listing_type'],
            'price' => $validated['price'],
            'price_unit' => $payload['price_unit'],
            'area' => $payload['area'],
            'area_unit' => $payload['area_unit'],
            'bedrooms' => $payload['bedrooms'],
            'bathrooms' => $payload['bathrooms'],
            'garages' => $payload['garages'],
            'year_built' => $payload['year_built'],
            'address' => $payload['address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'country' => $validated['country'] ?? 'Nigeria',
            'zip_code' => $validated['zip_code'] ?? null,
            'latitude' => $payload['latitude'],
            'longitude' => $payload['longitude'],
            'amenities' => $payload['amenities'],
            'is_featured' => (bool) ($validated['is_featured'] ?? false),
            'is_premium' => (bool) ($validated['is_premium'] ?? false),
            'status' => $status,
            'approved_by' => $status === Property::STATUS_APPROVED ? auth()->id() : null,
            'approved_at' => $status === Property::STATUS_APPROVED ? now() : null,
            'published_at' => $status === Property::STATUS_APPROVED ? now() : null,
        ]);

        $this->storePropertyImages($request, $property);

        Cache::forget('admin:dashboard:stats');

        return back()->with('status', 'Property listing created successfully.');
    }

    public function approveProperty(Property $property): RedirectResponse
    {
        $property->update([
            'status' => Property::STATUS_APPROVED,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'rejection_reason' => null,
            'published_at' => $property->published_at ?? now(),
        ]);

        Cache::forget('admin:dashboard:stats');

        return back()->with('status', 'Property approved.');
    }

    public function rejectProperty(Request $request, Property $property): RedirectResponse
    {
        $validated = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:1000'],
        ]);

        $property->update([
            'status' => Property::STATUS_REJECTED,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        Cache::forget('admin:dashboard:stats');

        return back()->with('status', 'Property rejected.');
    }

    public function deleteProperty(Property $property): RedirectResponse
    {
        $this->authorize('delete', $property);

        $property->delete();

        Cache::forget('admin:dashboard:stats');

        return back()->with('status', 'Property deleted successfully.');
    }

    public function plans(): View
    {
        $plans = Plan::query()
            ->latest()
            ->paginate(self::PER_PAGE);

        return view('admin.plans.index', compact('plans'));
    }

    public function storePlan(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['required', 'string', 'max:100', 'unique:plans,slug'],
            'description' => ['nullable', 'string'],
            'price_monthly' => ['required', 'numeric', 'min:0'],
            'price_yearly' => ['nullable', 'numeric', 'min:0'],
            'listing_limit' => ['required', 'integer', 'min:0'],
            'duration_days' => ['required', 'integer', 'min:1'],
            'features' => ['nullable', 'string'],
            'is_popular' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['features'] = $this->parseFeatures($validated['features'] ?? null);
        $validated['is_popular'] = (bool) ($validated['is_popular'] ?? false);
        $validated['is_active'] = (bool) ($validated['is_active'] ?? true);

        Plan::create($validated);

        Cache::forget('admin:dashboard:stats');

        return back()->with('status', 'Plan created successfully.');
    }

    public function updatePlan(Request $request, Plan $plan): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['required', 'string', 'max:100', 'unique:plans,slug,'.$plan->id],
            'description' => ['nullable', 'string'],
            'price_monthly' => ['required', 'numeric', 'min:0'],
            'price_yearly' => ['nullable', 'numeric', 'min:0'],
            'listing_limit' => ['required', 'integer', 'min:0'],
            'duration_days' => ['required', 'integer', 'min:1'],
            'features' => ['nullable', 'string'],
            'is_popular' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['features'] = $this->parseFeatures($validated['features'] ?? null);
        $validated['is_popular'] = (bool) ($validated['is_popular'] ?? false);
        $validated['is_active'] = (bool) ($validated['is_active'] ?? false);

        $plan->update($validated);

        Cache::forget('admin:dashboard:stats');

        return back()->with('status', 'Plan updated.');
    }

    public function deletePlan(Plan $plan): RedirectResponse
    {
        $plan->delete();

        Cache::forget('admin:dashboard:stats');

        return back()->with('status', 'Plan deleted.');
    }

    public function subscriptions(Request $request): View
    {
        $status = $request->string('status')->toString();

        $subscriptions = Subscription::query()
            ->select(['id', 'agent_id', 'plan_id', 'status', 'starts_at', 'ends_at', 'created_at'])
            ->with([
                'agent:id,user_id',
                'agent.user:id,name,email',
                'plan:id,name',
            ])
            ->byStatus($status)
            ->latest()
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        return view('admin.subscriptions.index', compact('subscriptions', 'status'));
    }

    public function updateSubscription(Request $request, Subscription $subscription): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:active,pending,canceled,expired'],
            'ends_at' => ['nullable', 'date'],
        ]);

        $subscription->update([
            'status' => $validated['status'],
            'ends_at' => $validated['ends_at'] ?? $subscription->ends_at,
            'canceled_at' => $validated['status'] === Subscription::STATUS_CANCELED ? now() : null,
        ]);

        Cache::forget('admin:dashboard:stats');

        return back()->with('status', 'Subscription updated.');
    }

    public function inquiries(Request $request): View
    {
        $status = $request->string('status')->toString();

        $inquiries = Inquiry::query()
            ->select(['id', 'user_id', 'property_id', 'agent_id', 'name', 'email', 'message', 'status', 'admin_notes', 'created_at'])
            ->with([
                'user:id,name,email',
                'property:id,title,city,state',
                'agent:id,user_id',
                'agent.user:id,name,email',
            ])
            ->byStatus($status)
            ->latest()
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        return view('admin.inquiries.index', compact('inquiries', 'status'));
    }

    public function updateInquiry(Request $request, Inquiry $inquiry): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:new,contacted,closed'],
            'admin_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $inquiry->update([
            'status' => $validated['status'],
            'admin_notes' => $validated['admin_notes'] ?? null,
            'responded_at' => in_array($validated['status'], [Inquiry::STATUS_CONTACTED, Inquiry::STATUS_CLOSED], true) ? now() : null,
        ]);

        Cache::forget('admin:dashboard:stats');

        return back()->with('status', 'Inquiry updated.');
    }

    public function reports(Request $request): View
    {
        $status = $request->string('status')->toString();

        $reports = Report::query()
            ->select(['id', 'user_id', 'property_id', 'reason', 'description', 'status', 'admin_notes', 'resolved_by', 'created_at'])
            ->with([
                'user:id,name,email',
                'property:id,title,city,state',
                'resolver:id,name,email',
            ])
            ->byStatus($status)
            ->latest()
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        return view('admin.reports.index', compact('reports', 'status'));
    }

    public function updateReport(Request $request, Report $report): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,reviewed,resolved,dismissed'],
            'admin_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $report->update([
            'status' => $validated['status'],
            'admin_notes' => $validated['admin_notes'] ?? null,
            'resolved_by' => in_array($validated['status'], [Report::STATUS_RESOLVED, Report::STATUS_DISMISSED], true) ? auth()->id() : null,
            'resolved_at' => in_array($validated['status'], [Report::STATUS_RESOLVED, Report::STATUS_DISMISSED], true) ? now() : null,
        ]);

        Cache::forget('admin:dashboard:stats');

        return back()->with('status', 'Report updated.');
    }

    public function users(Request $request): View
    {
        $role = $request->string('role')->toString();
        $search = $request->string('search')->toString();

        $users = User::query()
            ->select(['id', 'name', 'email', 'role', 'is_active', 'created_at'])
            ->byRole($role)
            ->search($search)
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'role', 'search'));
    }

    public function updateUser(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'role' => ['required', 'in:user,agent,admin'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $user->update([
            'role' => $validated['role'],
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ]);

        Cache::forget('admin:dashboard:stats');

        return back()->with('status', 'User updated.');
    }

    public function settings(): View
    {
        $settings = Setting::query()->orderBy('group')->orderBy('key')->get()->groupBy('group');

        return view('admin.settings.index', compact('settings'));
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $request->validate([
            'settings.site_name' => ['nullable', 'string', 'max:150'],
            'favicon' => ['nullable', 'file', 'mimes:ico,png,jpg,jpeg,svg', 'max:2048'],
            'app_logo' => ['nullable', 'file', 'mimes:png,jpg,jpeg,svg,webp', 'max:4096'],
        ]);

        $payload = $request->input('settings', []);

        foreach ($payload as $key => $value) {
            $setting = Setting::where('key', $key)->first();

            if (! $setting) {
                continue;
            }

            $setting->update([
                'value' => $this->normalizeSettingValue($setting->type, $value),
            ]);
        }

        if (array_key_exists('site_name', $payload)) {
            Setting::updateOrCreate(
                ['key' => 'site_name'],
                [
                    'value' => (string) $payload['site_name'],
                    'type' => 'string',
                    'group' => 'general',
                    'label' => 'Site Name',
                    'description' => 'Application name shown in title and branding areas.',
                ],
            );
        }

        if ($request->hasFile('favicon')) {
            $path = $request->file('favicon')->store('branding', 'public');

            Setting::updateOrCreate(
                ['key' => 'favicon_path'],
                [
                    'value' => $path,
                    'type' => 'string',
                    'group' => 'branding',
                    'label' => 'Favicon',
                    'description' => 'Small icon shown in browser tabs.',
                ],
            );
        }

        if ($request->hasFile('app_logo')) {
            $path = $request->file('app_logo')->store('branding', 'public');

            Setting::updateOrCreate(
                ['key' => 'logo_path'],
                [
                    'value' => $path,
                    'type' => 'string',
                    'group' => 'branding',
                    'label' => 'Application Logo',
                    'description' => 'Logo image shown in navigation and branded areas.',
                ],
            );
        }

        Cache::forget('admin:dashboard:stats');

        return back()->with('status', 'Settings updated.');
    }

    private function parseFeatures(?string $features): ?array
    {
        if (! $features) {
            return null;
        }

        return collect(preg_split('/[\r\n,]+/', $features))
            ->map(fn ($item) => trim((string) $item))
            ->filter()
            ->values()
            ->all();
    }

    private function normalizeSettingValue(string $type, mixed $value): string
    {
        return match ($type) {
            'integer' => (string) (int) $value,
            'boolean' => in_array((string) $value, ['1', 'true', 'on'], true) ? '1' : '0',
            'json', 'array' => json_encode($value ?? []),
            default => (string) $value,
        };
    }

    private function parseAmenities(?string $amenities): ?array
    {
        if (! $amenities) {
            return null;
        }

        return collect(preg_split('/[\r\n,]+/', $amenities))
            ->map(fn ($item) => trim((string) $item))
            ->filter()
            ->values()
            ->all();
    }

    private function normalizePropertyPayload(array $validated): array
    {
        $type = $validated['property_type'];
        $supports = fn (string $field): bool => Property::supportsDetailField($type, $field);
        $location = trim(implode(', ', array_filter([
            $validated['city'] ?? null,
            $validated['state'] ?? null,
            $validated['country'] ?? 'Nigeria',
        ])));

        return [
            'description' => filled($validated['description'] ?? null)
                ? trim($validated['description'])
                : (trim($validated['short_description'] ?? '') ?: 'Property listing in '.$location),
            'price_unit' => $validated['price_unit'] ?? ($validated['listing_type'] === Property::LISTING_RENT ? 'per_year' : 'total'),
            'area' => $supports('area') ? $this->nullableNumber($validated['area'] ?? null) : null,
            'area_unit' => $supports('area') ? ($validated['area_unit'] ?? 'sqm') : null,
            'bedrooms' => $supports('bedrooms') ? ($validated['bedrooms'] ?? null) : null,
            'bathrooms' => $supports('bathrooms') ? ($validated['bathrooms'] ?? null) : null,
            'garages' => $supports('garages') ? ($validated['garages'] ?? null) : null,
            'year_built' => $supports('year_built') ? ($validated['year_built'] ?? null) : null,
            'address' => filled($validated['address'] ?? null) ? trim($validated['address']) : $location,
            'latitude' => $this->nullableNumber($validated['latitude'] ?? null),
            'longitude' => $this->nullableNumber($validated['longitude'] ?? null),
            'amenities' => $supports('amenities') ? $this->parseAmenities($validated['amenities'] ?? null) : null,
        ];
    }

    private function nullableNumber(mixed $value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        return (float) $value;
    }

    private function storePropertyImages(Request $request, Property $property): void
    {
        if (! $request->hasFile('images')) {
            return;
        }

        foreach ($request->file('images') as $index => $image) {
            if (! $image->isValid()) {
                continue;
            }

            PropertyImage::create([
                'property_id' => $property->id,
                'image_path' => $image->store('properties', 'public'),
                'is_primary' => $index === 0,
                'order' => $index + 1,
                'alt_text' => $property->title,
            ]);
        }
    }

    private function nigerianStates(): array
    {
        return [
            'Abia', 'Adamawa', 'Akwa Ibom', 'Anambra', 'Bauchi', 'Bayelsa', 'Benue', 'Borno',
            'Cross River', 'Delta', 'Ebonyi', 'Edo', 'Ekiti', 'Enugu', 'FCT - Abuja', 'Gombe',
            'Imo', 'Jigawa', 'Kaduna', 'Kano', 'Katsina', 'Kebbi', 'Kogi', 'Kwara', 'Lagos',
            'Nasarawa', 'Niger', 'Ogun', 'Ondo', 'Osun', 'Oyo', 'Plateau', 'Rivers',
            'Sokoto', 'Taraba', 'Yobe', 'Zamfara',
        ];
    }

    private function generatePropertySlug(string $title): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $counter = 1;

        while (Property::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
