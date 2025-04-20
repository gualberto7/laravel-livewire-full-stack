<div>
    <x-gc.table>
        <x-slot:header>
            <tr>
                <x-gc.th>
                    Nombre
                </x-gc.th>
                <x-gc.th>
                    Precio
                </x-gc.th>
                <x-gc.th>
                    Duración
                </x-gc.th>
                <x-gc.th>
                    Acciones
                </x-gc.th>
            </tr>
        </x-slot:header>

        @forelse ($memberships as $membership)
            <tr>
                <x-gc.td variant="strong">
                    {{ $membership->name }}
                </x-gc.td>
                <x-gc.td>
                    {{ $membership->price }} Bs.
                </x-gc.td>
                <x-gc.td>
                    {{ $membership->duration }} días
                </x-gc.td>
                <x-gc.td>
                    <div class="flex items-center gap-3">
                        <flux:tooltip content="Editar">
                            <flux:button icon="pencil" size="xs" variant="primary" wire:click="editMembership('{{ $membership->id }}')" />
                        </flux:tooltip>
                        <flux:tooltip content="Eliminar">
                            <flux:button icon="trash" size="xs" variant="danger" wire:click="deleteMembership('{{ $membership->id }}')" />
                        </flux:tooltip>
                    </div>
                </x-gc.td>
            </tr>
        @empty
            <tr>
                <x-gc.td colspan="5" class="text-center">
                    No se encontraron membresías.
                </x-gc.td>
            </tr>
        @endforelse
    </x-gc.table>
</div>
