<x-layouts.app :title="__('Personal')">
    <div class="flex h-full w-full mx-auto max-w-7xl flex-1 flex-col gap-4">
        <div>
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Personal</h1>
                {{-- <flux:button href="{{ route('memberships.create') }}">Crear Membresía</flux:button> --}}
            </div>
        </div>
        <div>
            <livewire:staff.index />
        </div>
    </div>
</x-layouts.app>
