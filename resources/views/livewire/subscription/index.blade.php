<div>
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-4">
            <div class="flex gap-x-4">
                <div class="flex-1">
                    <flux:input 
                        wire:model.live.debounce.500ms="search" 
                        placeholder="Buscar por nombre o membresía..." />
                </div>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <flux:select wire:model.live="perPage">
                @foreach ([10, 15, 30, 50] as $value)
                    <flux:select.option :value="$value">
                        {{ $value }} por página
                    </flux:select.option>
                @endforeach
            </flux:select>
            <flux:button variant="primary" icon="plus" href="{{ route('subscriptions.create') }}" navigate>
                Crear Suscripción   
            </flux:button>
        </div>
    </div>

    <x-gc.table :paginate="$subscriptions">
        <x-slot:header>
            <tr>
                <x-gc.th sortable :sorted="$sortField === 'client_id'" :direction="$sortDirection" wire:click="sortBy('client_id')">
                    Cliente
                </x-gc.th>
                <x-gc.th>
                    Membresía
                </x-gc.th>
                <x-gc.th>
                    Fecha Fin
                </x-gc.th>
                <x-gc.th>
                    Estado
                </x-gc.th>
                <x-gc.th>
                    Acciones
                </x-gc.th>
            </tr>
        </x-slot:header>

        @forelse ($subscriptions as $subscription)
            <tr>
                <x-gc.td variant="strong">
                    <flux:link :href="route('clients.show', $subscription->client->id)">
                        {{ $subscription->client->name }}
                    </flux:link>
                </x-gc.td>
                <x-gc.td>
                    {{ $subscription->membership->name }}
                </x-gc.td>
                <x-gc.td>
                    {{ $subscription->end_date->format('d/m/Y') }}
                </x-gc.td>
                <x-gc.td>
                    <flux:badge :color="$subscription->getStatusColor()">
                        {{ ucfirst($subscription->getStatus()) }}
                    </flux:badge>
                </x-gc.td>
                <x-gc.td>
                    <flux:button size="sm" wire:click="registerCheckIn('{{ $subscription->client->id }}')">
                        Registrar entrada
                    </flux:button>
                </x-gc.td>
            </tr>
        @empty
            <tr>
                <x-gc.td colspan="5" class="text-center">
                    No se encontraron suscripciones.
                </x-gc.td>
            </tr>
        @endforelse
    </x-gc.table>
</div>
