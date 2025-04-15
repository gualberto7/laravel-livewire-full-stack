<div class="mx-auto max-w-7xl px-4 sm:px-6 md:px-8">
    <div class="py-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="w-1/3 mb-4 sm:mb-0">
                <div class="relative rounded-md shadow-sm">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input wire:model.live.debounce.300ms="search" type="text" class="block w-full rounded-md border-0 py-1.5 pl-10 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-zinc-800 dark:text-white dark:ring-zinc-700 dark:placeholder:text-zinc-500" placeholder="Buscar por cliente o membresía...">
                </div>
            </div>
            <div>
                <select wire:model.live="perPage" class="block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-zinc-800 dark:text-white dark:ring-zinc-700">
                    <option value="5">5 por página</option>
                    <option value="10">10 por página</option>
                    <option value="25">25 por página</option>
                    <option value="50">50 por página</option>
                </select>
            </div>
        </div>
    </div>

    <x-gc.table :paginate="$subscriptions">
        <x-slot:header>
            <tr>
                <x-gc.th sortable :sorted="$sortField === 'client_id'" :direction="$sortDirection" wire:click="sortBy('client_id')">
                    Cliente
                </x-gc.th>
                <x-gc.th sortable :sorted="$sortField === 'membership_id'" :direction="$sortDirection" wire:click="sortBy('membership_id')">
                    Membresía
                </x-gc.th>
                <x-gc.th sortable :sorted="$sortField === 'start_date'" :direction="$sortDirection" wire:click="sortBy('start_date')">
                    Fecha Inicio
                </x-gc.th>
                <x-gc.th sortable :sorted="$sortField === 'end_date'" :direction="$sortDirection" wire:click="sortBy('end_date')">
                    Fecha Fin
                </x-gc.th>
                <x-gc.th>
                    Estado
                </x-gc.th>
            </tr>
        </x-slot:header>

        @forelse ($subscriptions as $subscription)
            <tr>
                <x-gc.td variant="strong">
                    {{ $subscription->client->name ?? 'N/A' }}
                </x-gc.td>
                <x-gc.td>
                    {{ $subscription->membership->name ?? 'N/A' }}
                </x-gc.td>
                <x-gc.td>
                    {{ $subscription->start_date->format('d/m/Y') ?? 'N/A' }}
                </x-gc.td>
                <x-gc.td>
                    {{ $subscription->end_date->format('d/m/Y') ?? 'N/A' }}
                </x-gc.td>
                <x-gc.td>
                    <flux:badge :color="$subscription->getStatusColor()">
                        {{ ucfirst($subscription->getStatus()) }}
                    </flux:badge>
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
