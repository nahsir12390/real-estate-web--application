@php
    $siteName = \App\Models\Setting::value('site_name', config('app.name', 'Laravel'));
    $faviconPath = \App\Models\Setting::value('favicon_path');
@endphp

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>
    {{ filled($title ?? null) ? $title.' - '.$siteName : $siteName }}
</title>

@if($faviconPath)
    <link rel="icon" href="{{ \Illuminate\Support\Facades\Storage::url($faviconPath) }}" sizes="any">
@else
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
@endif

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
