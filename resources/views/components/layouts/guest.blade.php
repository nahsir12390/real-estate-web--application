@props(['title' => 'Marketplace'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-900">
        <header class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-950">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
                <x-app-logo href="{{ route('home') }}" />

                <nav class="hidden items-center gap-2 text-sm md:flex">
                    <a href="{{ route('home') }}" class="rounded px-3 py-1.5 {{ request()->routeIs('home') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'text-zinc-700 hover:bg-zinc-200 dark:text-zinc-200 dark:hover:bg-zinc-800' }}">Home</a>
                    <a href="{{ route('properties.index') }}" class="rounded px-3 py-1.5 {{ request()->routeIs('properties.*') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'text-zinc-700 hover:bg-zinc-200 dark:text-zinc-200 dark:hover:bg-zinc-800' }}">Properties</a>
                    <a href="{{ route('login') }}" class="rounded border border-zinc-300 px-3 py-1.5 text-zinc-700 hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800">Login</a>
                    @if(Route::has('register'))
                        <a href="{{ route('register') }}" class="rounded bg-zinc-900 px-3 py-1.5 text-white hover:bg-zinc-700 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-300">Register</a>
                    @endif
                </nav>

                <div class="md:hidden">
                    <flux:dropdown position="bottom" align="end">
                        <flux:button variant="ghost" size="sm" icon="bars-2" />

                        <flux:menu>
                            <flux:menu.item :href="route('home')" wire:navigate>Home</flux:menu.item>
                            <flux:menu.item :href="route('properties.index')" wire:navigate>Properties</flux:menu.item>
                            <flux:menu.separator />
                            <flux:menu.item :href="route('login')" wire:navigate>Login</flux:menu.item>
                            @if(Route::has('register'))
                                <flux:menu.item :href="route('register')" wire:navigate>Register</flux:menu.item>
                            @endif
                        </flux:menu>
                    </flux:dropdown>
                </div>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            {{ $slot }}
        </main>

        @fluxScripts
    </body>
</html>
