@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <header class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <x-app-logo href="{{ route('user.home') }}" />
                    </div>

                    <nav class="hidden md:flex md:flex-1 md:items-center md:justify-center md:gap-2">
                        <a href="{{ route('user.home') }}" 
                           class="rounded-md px-3 py-2 text-sm font-medium transition {{ request()->routeIs('user.home') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'text-zinc-700 hover:bg-zinc-200 dark:text-zinc-200 dark:hover:bg-zinc-800' }}">
                            Home
                        </a>
                        <a href="{{ route('user.favorites') }}" 
                           class="rounded-md px-3 py-2 text-sm font-medium transition {{ request()->routeIs('user.favorites') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'text-zinc-700 hover:bg-zinc-200 dark:text-zinc-200 dark:hover:bg-zinc-800' }}">
                            Favorites
                        </a>
                        <a href="{{ route('user.inquiries') }}" 
                           class="rounded-md px-3 py-2 text-sm font-medium transition {{ request()->routeIs('user.inquiries') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'text-zinc-700 hover:bg-zinc-200 dark:text-zinc-200 dark:hover:bg-zinc-800' }}">
                            Inquiries
                        </a>
                        <a href="{{ route('user.reports') }}" 
                           class="rounded-md px-3 py-2 text-sm font-medium transition {{ request()->routeIs('user.reports') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'text-zinc-700 hover:bg-zinc-200 dark:text-zinc-200 dark:hover:bg-zinc-800' }}">
                            Reports
                        </a>
                    </nav>

                    <div class="hidden md:flex md:items-center md:gap-2">
                        <x-desktop-user-menu />
                    </div>

                    <div class="flex md:hidden">
                        <flux:dropdown position="bottom" align="end">
                            <flux:button variant="ghost" size="sm" icon="bars-2" />

                            <flux:menu>
                                <flux:menu.item :href="route('user.home')" wire:navigate>Home</flux:menu.item>
                                <flux:menu.item :href="route('user.favorites')" wire:navigate>Favorites</flux:menu.item>
                                <flux:menu.item :href="route('user.inquiries')" wire:navigate>Inquiries</flux:menu.item>
                                <flux:menu.item :href="route('user.reports')" wire:navigate>Reports</flux:menu.item>
                                <flux:menu.separator />
                                <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>Settings</flux:menu.item>
                                <form method="POST" action="{{ route('logout') }}" class="w-full">
                                    @csrf
                                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full cursor-pointer">
                                        Log out
                                    </flux:menu.item>
                                </form>
                            </flux:menu>
                        </flux:dropdown>
                    </div>
                </div>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            {{ $slot }}
        </main>

        @fluxScripts
    </body>
</html>
