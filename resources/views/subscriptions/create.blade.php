<x-layouts.app :title="__('Crear Suscripción')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div>
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Crear suscripción</h1>
            </div>
        </div>
        <div>
            <livewire:subscription.create />
        </div>
    </div>
</x-layouts.app>
