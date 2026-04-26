@props([
    'sidebar' => false,
])

@php($appName = \App\Models\Setting::value('site_name', config('app.name', 'Laravel')))
@php($logoPath = \App\Models\Setting::value('logo_path'))

@if($sidebar)
    <flux:sidebar.brand :name="$appName" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-md bg-accent-content text-accent-foreground overflow-hidden">
            @if($logoPath)
                <img src="{{ \Illuminate\Support\Facades\Storage::url($logoPath) }}" alt="{{ $appName }} logo" class="h-full w-full object-contain bg-white p-0.5">
            @else
                <x-app-logo-icon class="size-5 fill-current text-white dark:text-black" />
            @endif
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand :name="$appName" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-md bg-accent-content text-accent-foreground overflow-hidden">
            @if($logoPath)
                <img src="{{ \Illuminate\Support\Facades\Storage::url($logoPath) }}" alt="{{ $appName }} logo" class="h-full w-full object-contain bg-white p-0.5">
            @else
                <x-app-logo-icon class="size-5 fill-current text-white dark:text-black" />
            @endif
        </x-slot>
    </flux:brand>
@endif
