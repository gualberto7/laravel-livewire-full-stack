<x-layouts.app :title="__('Detalles')">
    <div class="flex h-full w-full mx-auto max-w-7xl flex-1 flex-col gap-4">
        <div>
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Detalles del Personal</h1>
                @can('manage gym staff')
                    <div class="flex gap-2">
                        <flux:button> Editar</flux:button>
                        <flux:button variant="danger">Eliminar</flux:button>
                    </div>
                @endcan
            </div>
        </div>
        <div>
            <livewire:staff.show :staffMember="$staffMember" />
        </div>
    </div>
</x-layouts.app>
