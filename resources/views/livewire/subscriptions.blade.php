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
                    {{ $subscription->start_date ?? 'N/A' }}
                </x-gc.td>
                <x-gc.td>
                    {{ $subscription->end_date ?? 'N/A' }}
                </x-gc.td>
                <x-gc.td>
                    @php
                        $now = now();
                        $status = 'inactive';
                        $color = 'zinc';
                        
                        if ($subscription->start_date && $subscription->end_date) {
                            if ($now->between($subscription->start_date, $subscription->end_date)) {
                                $status = 'activa';
                                $color = 'emerald';
                            } elseif ($now->lt($subscription->start_date)) {
                                $status = 'pendiente';
                                $color = 'amber';
                            } else {
                                $status = 'vencida';
                                $color = 'red';
                            }
                        }
                    @endphp
                    <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset
                        @if($color === 'emerald') text-emerald-700 bg-emerald-50 ring-emerald-600/20 dark:text-emerald-400 dark:bg-emerald-400/10
                        @elseif($color === 'amber') text-amber-700 bg-amber-50 ring-amber-600/20 dark:text-amber-400 dark:bg-amber-400/10
                        @elseif($color === 'red') text-red-700 bg-red-50 ring-red-600/20 dark:text-red-400 dark:bg-red-400/10
                        @else text-zinc-700 bg-zinc-50 ring-zinc-600/20 dark:text-zinc-400 dark:bg-zinc-400/10
                        @endif">
                        {{ ucfirst($status) }}
                    </span>
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
