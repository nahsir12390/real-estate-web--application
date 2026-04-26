<div class="mb-6 flex flex-wrap gap-2">
    <a href="{{ route('admin.dashboard') }}" class="rounded border px-3 py-1.5 text-sm {{ request()->routeIs('admin.dashboard') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'border-zinc-300 dark:border-zinc-700' }}">
        Dashboard
    </a>
    <a href="{{ route('admin.agents.index') }}" class="rounded border px-3 py-1.5 text-sm {{ request()->routeIs('admin.agents.*') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'border-zinc-300 dark:border-zinc-700' }}">
        Agents
    </a>
    <a href="{{ route('admin.verifications.index') }}" class="rounded border px-3 py-1.5 text-sm {{ request()->routeIs('admin.verifications.*') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'border-zinc-300 dark:border-zinc-700' }}">
        Verifications
    </a>
    <a href="{{ route('admin.properties.index') }}" class="rounded border px-3 py-1.5 text-sm {{ request()->routeIs('admin.properties.*') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'border-zinc-300 dark:border-zinc-700' }}">
        Properties
    </a>
    <a href="{{ route('admin.plans.index') }}" class="rounded border px-3 py-1.5 text-sm {{ request()->routeIs('admin.plans.*') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'border-zinc-300 dark:border-zinc-700' }}">
        Plans
    </a>
    <a href="{{ route('admin.subscriptions.index') }}" class="rounded border px-3 py-1.5 text-sm {{ request()->routeIs('admin.subscriptions.*') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'border-zinc-300 dark:border-zinc-700' }}">
        Subscriptions
    </a>
    <a href="{{ route('admin.inquiries.index') }}" class="rounded border px-3 py-1.5 text-sm {{ request()->routeIs('admin.inquiries.*') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'border-zinc-300 dark:border-zinc-700' }}">
        Inquiries
    </a>
    <a href="{{ route('admin.reports.index') }}" class="rounded border px-3 py-1.5 text-sm {{ request()->routeIs('admin.reports.*') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'border-zinc-300 dark:border-zinc-700' }}">
        Reports
    </a>
    <a href="{{ route('admin.users.index') }}" class="rounded border px-3 py-1.5 text-sm {{ request()->routeIs('admin.users.*') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'border-zinc-300 dark:border-zinc-700' }}">
        Users
    </a>
    <a href="{{ route('admin.settings.index') }}" class="rounded border px-3 py-1.5 text-sm {{ request()->routeIs('admin.settings.*') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'border-zinc-300 dark:border-zinc-700' }}">
        Settings
    </a>
</div>
