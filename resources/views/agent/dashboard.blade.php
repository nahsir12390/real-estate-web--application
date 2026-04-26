<x-layouts::app :title="__('Agent Dashboard')">
    <div class="p-6">
        <div class="mb-4 flex flex-wrap gap-2">
            <a href="{{ route('agent.properties.index') }}" class="rounded border border-zinc-300 px-3 py-1.5 text-sm dark:border-zinc-700">Properties</a>
            <a href="{{ route('agent.inquiries') }}" class="rounded border border-zinc-300 px-3 py-1.5 text-sm dark:border-zinc-700">Inquiries</a>
            <a href="{{ route('agent.subscription') }}" class="rounded border border-zinc-300 px-3 py-1.5 text-sm dark:border-zinc-700">Subscription</a>
            <a href="{{ route('agent.verification') }}" class="rounded border border-zinc-300 px-3 py-1.5 text-sm dark:border-zinc-700">Verification</a>
        </div>
        <livewire:agent.dashboard-stats />
    </div>
</x-layouts::app>
