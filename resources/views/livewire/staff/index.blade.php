<div>
    <x-gc.table>
        <x-slot:header>
            <tr>
                <x-gc.th>
                    Nombre
                </x-gc.th>
                <x-gc.th>
                    Teléfono
                </x-gc.th>
                <x-gc.th>
                    Rol
                </x-gc.th>
                <x-gc.th>
                    Acciones
                </x-gc.th>
            </tr>
        </x-slot:header>

        @forelse ($staff as $staffMember)
            <tr>
                <x-gc.td variant="strong">
                    {{ $staffMember->name }}
                </x-gc.td>
                <x-gc.td>
                    {{ $staffMember->phone }}
                </x-gc.td>
                <x-gc.td>
                    {{ $staffMember->role_name }}
                </x-gc.td>
                <x-gc.td>
                    <div class="flex items-center gap-3">
                        <flux:tooltip content="Editar">
                            <flux:button icon="pencil" size="xs" variant="primary" wire:click="editStaff({{ $staffMember->id }})" />
                        </flux:tooltip>
                        <flux:tooltip content="Eliminar">
                            <flux:button icon="trash" size="xs" variant="danger" wire:click="deleteStaff({{ $staffMember->id }})" />
                        </flux:tooltip>
                    </div>
                </x-gc.td>
            </tr>
        @empty
            <tr>
                <x-gc.td colspan="5" class="text-center">
                    No se encontraron personal.
                </x-gc.td>
            </tr>
        @endforelse
    </x-gc.table>
</div>
