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
                @if($canManageStaff)
                    <x-gc.th>
                        Acciones
                    </x-gc.th>
                @endif
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
                @if($canManageStaff)
                    <x-gc.td>
                        <div class="flex items-center gap-3">
                            <flux:tooltip content="Detalles">
                                <flux:button icon="eye" size="xs" variant="ghost" href="{{ route('staff.show', $staffMember->id) }}" />
                            </flux:tooltip>
                            <flux:tooltip content="Eliminar">
                                <flux:button icon="trash" size="xs" variant="danger" wire:click="deleteStaff({{ $staffMember->id }})" />
                            </flux:tooltip>
                        </div>
                    </x-gc.td>
                @endif
            </tr>
        @empty
            <tr>
                <x-gc.td colspan="{{ $canManageStaff ? 4 : 3 }}" class="text-center">
                    No se encontraron personal.
                </x-gc.td>
            </tr>
        @endforelse
    </x-gc.table>
</div>
