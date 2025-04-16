<x-layouts.app :title="__('Membresías')">
    <div class="flex h-full w-full mx-auto max-w-7xl flex-1 flex-col gap-4">
        <div>
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Membresías</h1>
                @can('add gym memberships')   
                    <flux:button href="{{ route('memberships.create') }}">Crear Membresía</flux:button>
                @endcan
            </div>
        </div>
        <div>
            <livewire:memberships />
        </div>
    </div>
</x-layouts.app>
