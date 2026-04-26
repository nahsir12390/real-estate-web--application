<x-layouts::app :title="__('Edit Property')">
    <div class="p-6">
        <h1 class="mb-4 text-2xl font-semibold">Edit Property</h1>
        <livewire:agent.property-form :property-id="$property->id" />
    </div>
</x-layouts::app>
