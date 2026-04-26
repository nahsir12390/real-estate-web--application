<x-layouts::app :title="__('Platform Settings')">
    <div class="p-6">
        <!-- Navigation Button -->
        <div class="mb-4 flex justify-end">
            <a href="{{ route('admin.dashboard') }}"
               class="inline-flex items-center rounded-md bg-zinc-900 px-3 py-1.5 text-sm font-medium text-white hover:bg-zinc-700 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-300">
                <svg class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Dashboard
            </a>
        </div>
        @include('admin.partials.nav')
        <h1 class="mb-4 text-2xl font-semibold">Platform Settings</h1>

        @if (session('status'))
            <div class="mb-4 rounded border border-green-300 bg-green-50 p-3 text-sm text-green-700">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PATCH')

            @php
                $siteName = \App\Models\Setting::value('site_name', config('app.name'));
                $faviconPath = \App\Models\Setting::value('favicon_path');
                $logoPath = \App\Models\Setting::value('logo_path');
            @endphp

            <div class="rounded border border-zinc-200 p-4 dark:border-zinc-700">
                <h2 class="mb-3 text-lg font-semibold">Branding</h2>
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-medium">Application Name</label>
                        <input
                            name="settings[site_name]"
                            value="{{ old('settings.site_name', $siteName) }}"
                            class="w-full rounded border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-900"
                        >
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium">Favicon</label>
                        <input
                            type="file"
                            name="favicon"
                            accept=".ico,.png,.jpg,.jpeg,.svg"
                            class="w-full rounded border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-900"
                        >
                        <p class="mt-1 text-xs text-zinc-500">Accepted: ICO, PNG, JPG, JPEG, SVG (max 2MB)</p>
                        @if($faviconPath)
                            <div class="mt-2 flex items-center gap-2">
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($faviconPath) }}" alt="Current favicon" class="h-6 w-6 rounded border border-zinc-200 dark:border-zinc-700">
                                <span class="text-xs text-zinc-500">Current favicon</span>
                            </div>
                        @endif
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium">Application Logo</label>
                        <input
                            type="file"
                            name="app_logo"
                            accept=".png,.jpg,.jpeg,.svg,.webp"
                            class="w-full rounded border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-900"
                        >
                        <p class="mt-1 text-xs text-zinc-500">Accepted: PNG, JPG, JPEG, SVG, WEBP (max 4MB)</p>
                        @if($logoPath)
                            <div class="mt-2 flex items-center gap-2">
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($logoPath) }}" alt="Current logo" class="h-8 w-auto rounded border border-zinc-200 bg-white p-1 dark:border-zinc-700 dark:bg-zinc-900">
                                <span class="text-xs text-zinc-500">Current logo</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @foreach($settings as $group => $groupSettings)
                <div class="rounded border border-zinc-200 p-4 dark:border-zinc-700">
                    <h2 class="mb-3 text-lg font-semibold">{{ ucfirst($group) }}</h2>
                    <div class="grid gap-3 md:grid-cols-2">
                        @foreach($groupSettings as $setting)
                            @continue(in_array($setting->key, ['site_name', 'favicon_path', 'logo_path'], true))
                            <div>
                                <label class="mb-1 block text-sm font-medium">{{ $setting->label ?: $setting->key }}</label>

                                @if($setting->type === 'boolean')
                                    <select name="settings[{{ $setting->key }}]" class="w-full rounded border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-900">
                                        <option value="1" @selected($setting->value === '1')>True</option>
                                        <option value="0" @selected($setting->value === '0')>False</option>
                                    </select>
                                @else
                                    <input
                                        name="settings[{{ $setting->key }}]"
                                        value="{{ $setting->value }}"
                                        class="w-full rounded border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-900"
                                    >
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <button class="rounded bg-zinc-900 px-4 py-2 text-white dark:bg-zinc-100 dark:text-zinc-900">Save Settings</button>
        </form>
    </div>
</x-layouts::app>
