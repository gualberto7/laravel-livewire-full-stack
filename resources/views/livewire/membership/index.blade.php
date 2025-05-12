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
                    @if($membership->is_promo)
                        <div class="flex flex-col gap-2">
                            <div>
                            {{ $membership->name }}
                                <flux:badge color="teal" size="sm">
                                    Promoción
                                </flux:badge>
                            </div>
                            <div class="text-sm text-gray-300">
                                {{ $membership->promo_start_date->format('d/m/Y') }} - {{ $membership->promo_end_date->format('d/m/Y') }}
                            </div>
                        </div>
                    @else
                        <div>
                            {{ $membership->name }}
                        </div>
                    @endif
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
                            <flux:button icon="pencil" size="xs" variant="primary" href="{{ route('memberships.edit', $membership->id) }}" navigate />
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
