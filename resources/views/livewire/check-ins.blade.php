<div>
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-4">
            <flux:field>
                <flux:input
                    class="max-w-xs"
                    wire:model.live.debounce.300ms="search" 
                    placeholder="Buscar por nombre o CI..."
                    icon="magnifying-glass"
                    clearable
                />
            </flux:field>

        </div>
        <div>
            <flux:select wire:model.live="selectedDay">
                @foreach ($daysOfWeek as $key => $day)
                    <flux:select.option :value="$key">
                        {{ $day }}
                    </flux:select.option>
                @endforeach
            </flux:select>
        </div>
        <div>
            <flux:select wire:model.live="perPage">
                @foreach ([15, 30, 45, 60] as $value)
                    <flux:select.option :value="$value">
                        {{ $value }} por página
                    </flux:select.option>
                @endforeach
            </flux:select>
        </div>
    </div>

    <x-gc.table>
        <x-slot name="header">
            <x-gc.th wire:click="sortBy('client_id')" :sortField="$sortField" :sortDirection="$sortDirection" sortable>
                Cliente
            </x-gc.th>
            <x-gc.th>
                Fecha
            </x-gc.th>
            <x-gc.th>
                Hora
            </x-gc.th>
            <x-gc.th>
                Registrado por
            </x-gc.th>
        </x-slot>

        @forelse ($checkIns as $checkIn)
            <tr>
                <x-gc.td>
                    <flux:link :href="route('clients.show', $checkIn->client->id)">
                        {{ $checkIn->client->name }}
                    </flux:link>
                </x-gc.td>
                <x-gc.td>
                    {{ $checkIn->created_at->format('d/m/Y') }}
                </x-gc.td>
                <x-gc.td>
                    {{ $checkIn->created_at->format('H:i') }}
                </x-gc.td>
                <x-gc.td>
                    {{ $checkIn->created_by }}
                </x-gc.td>
            </tr>
        @empty
            <tr>
                <x-gc.td colspan="4" class="text-center">
                    No hay check-ins registrados
                </x-gc.td>
            </tr>
        @endforelse
    </x-gc.table>

    <div class="mt-4">
        {{ $checkIns->links() }}
    </div>
</div> 