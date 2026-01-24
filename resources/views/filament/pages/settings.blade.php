<x-filament-panels::page>
    <x-filament-panels::form wire:submit="submitSettings">
        {{ $this->form }}

        <x-filament-panels::form.actions
            :actions="$this->getFormActions()"
        />
    </x-filament-panels::form>

    <x-filament::section class="mt-6">
        <x-slot name="heading">
            Maintenance Actions
        </x-slot>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-filament::button 
                    wire:click="clearCache" 
                    color="warning" 
                    class="w-full flex items-center justify-center"
                >
                    <x-heroicon-o-trash class="w-5 h-5 mr-2" />
                    Clear All Caches
                </x-filament::button>
                <p class="mt-2 text-sm text-gray-500">
                    <strong>Clear Caches:</strong> Clears all application caches (config, views, routes).
                </p>
            </div>

            <div>
                <x-filament::button 
                    wire:click="optimizeApp" 
                    color="success" 
                    class="w-full flex items-center justify-center"
                >
                    <x-heroicon-o-bolt class="w-5 h-5 mr-2" />
                    Optimize Application
                </x-filament::button>
                <p class="mt-2 text-sm text-gray-500">
                    <strong>Optimize:</strong> Caches configuration, routes, and views for better performance.
                </p>
            </div>
        </div>
    </x-filament::section>
</x-filament-panels::page>