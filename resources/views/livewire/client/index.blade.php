<div>
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div class="w-full sm:w-auto">
            <flux:input 
                wire:model.live.debounce.300ms="search" 
                placeholder="Buscar por nombre o CI..." 
                icon="magnifying-glass"
            />
        </div>

        <div class="flex items-center gap-2">
            <flux:button 
                wire:click="filterByStatus('all')" 
                :variant="$subscriptionStatus === 'all' ? 'filled' : 'ghost'"
                size="sm"
            >
                Todos
            </flux:button>
            <flux:button 
                wire:click="filterByStatus('active')" 
                :variant="$subscriptionStatus === 'active' ? 'filled' : 'ghost'"
                color="emerald"
                size="sm"
            >
                Activos
            </flux:button>
            <flux:button 
                wire:click="filterByStatus('expired')" 
                :variant="$subscriptionStatus === 'expired' ? 'filled' : 'ghost'"
                color="red"
                size="sm"
            >
                Vencidos
            </flux:button>
        </div>
        
        <div class="flex flex-wrap items-center gap-3">
            <div class="w-full sm:w-auto self-end">
                <flux:button variant="primary" icon="plus" href="{{ route('clients.create') }}" navigate>
                    Nuevo Cliente
                </flux:button>
            </div>
        </div>
    </div>
    
    <x-gc.table :paginate="$clients">
        <x-slot:header>
            <tr>
                <x-gc.th sortable :sorted="$sortField === 'name'" :direction="$sortDirection" wire:click="sortBy('name')">
                    Nombre
                </x-gc.th>
                <x-gc.th>
                    CI
                </x-gc.th>
                <x-gc.th>
                    Teléfono
                </x-gc.th>
                <x-gc.th>
                    Estado
                </x-gc.th>
                <x-gc.th>
                    Acciones
                </x-gc.th>
            </tr>
        </x-slot:header>

        @forelse($clients as $client)
            <tr>
                <x-gc.td variant="strong">
                    <flux:link :href="route('clients.show', $client)">
                        {{ $client->name }}
                    </flux:link>
                </x-gc.td>
                <x-gc.td>
                    {{ $client->ci }}
                </x-gc.td>
                <x-gc.td>
                    {{ $client->phone }}
                </x-gc.td>
                <x-gc.td>
                    @if ($client->subscriptions->count() > 0)
                        <flux:badge :color="$client->subscriptions->first()->getStatusColor()">
                            {{ ucfirst($client->subscriptions->first()->getStatus()) }}
                        </flux:badge>
                    @else
                        <flux:badge color="gray">
                            Sin suscripción
                        </flux:badge>
                    @endif
                </x-gc.td>
                <x-gc.td>
                    <div class="flex items-center gap-3">
                        <flux:tooltip content="Detalles">
                            <flux:button icon="eye" size="xs" variant="ghost" />
                        </flux:tooltip>
                        <flux:tooltip content="Editar">
                            <flux:button icon="pencil" size="xs" variant="filled" href="{{ route('clients.edit', $client) }}" navigate />
                        </flux:tooltip>
                        <flux:tooltip content="Eliminar">
                            <flux:button icon="trash" size="xs" variant="danger" />
                        </flux:tooltip>
                    </div>
                </x-gc.td>
            </tr>
        @empty
            <tr>
                <x-gc.td colspan="5" class="text-center">
                    No se encontraron clientes.
                </x-gc.td>
            </tr>
        @endforelse
    </x-gc.table>
</div>
