<x-layouts.app :title="__('Suscripciones')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="py-6">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 md:px-8">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Suscripciones</h1>
                    <flux:button>Crear Suscripción</flux:button>
                </div>
            </div>
        </div>
        <div>
            <livewire:subscriptions />
        </div>
    </div>
</x-layouts.app>
