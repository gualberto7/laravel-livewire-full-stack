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

        @forelse ($clients as $client)
            <tr>
                <x-gc.td variant="strong">
                    {{ $client->name }}
                </x-gc.td>
                <x-gc.td>
                    {{ $client->phone }}
                </x-gc.td>
                <x-gc.td>
                    {{ $client->email }}
                </x-gc.td>
                <x-gc.td>
                    <div class="flex items-center gap-3">
                        <flux:tooltip content="Detalles">
                            <flux:button icon="eye" size="xs" variant="ghost" />
                        </flux:tooltip>
                        <flux:tooltip content="Eliminar">
                            <flux:button icon="trash" size="xs" variant="danger" />
                        </flux:tooltip>
                    </div>
                </x-gc.td>
            </tr>
        @empty
            <tr>
                <x-gc.td colspan="4" class="text-center">
                    No se encontraron clientes.
                </x-gc.td>
            </tr>
        @endforelse
    </x-gc.table>
</div>
