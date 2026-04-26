<x-layouts.user :title="__('Property Details')">
    <div class="space-y-6">
        <!-- Back Button (Simplified) -->
       

        <!-- Property Show Component -->
        <livewire:user.property-show :property-id="$property->id" />
    </div>
</x-layouts.user>