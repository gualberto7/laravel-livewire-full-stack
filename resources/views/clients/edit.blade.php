<x-layouts.app :title="__('Editar Cliente')">
    <div class="flex h-full w-full mx-auto max-w-7xl flex-1 flex-col gap-4">
        <div>
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Editar Cliente</h1>
            </div>
        </div>
        <div>
            <livewire:client.edit :client="$client" />
        </div>
    </div>
</x-layouts.app>
