<x-layouts.app :title="__('Clientes')">
    <div class="flex h-full w-full mx-auto max-w-7xl flex-1 flex-col gap-4">
        <div>
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Clientes</h1>
                {{-- <flux:button href="{{ route('staff.create') }}">Agregar Personal</flux:button> --}}
            </div>
        </div>
        <div>
            <livewire:client.index />
        </div>
    </div>
</x-layouts.app>
