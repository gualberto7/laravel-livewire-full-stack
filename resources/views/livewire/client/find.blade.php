<div>
    <div class="space-y-2">
        <flux:label>Buscar cliente por CI</flux:label>
        <div class="flex gap-x-4">
            <div class="flex-1">
                <flux:input 
                    wire:model.live="ci" 
                    wire:keyup="searchClient"
                    placeholder="Ingrese el CI del cliente" />
            </div>
        </div>
        
        @if($selectedClient)
            <div class="rounded-lg bg-zinc-800 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-white">{{ $selectedClient->name }}</p>
                        <p class="text-sm text-zinc-400">CI: {{ $selectedClient->ci }}</p>
                    </div>
                    <flux:button icon:trailing="x-mark" size="xs" variant="danger" wire:click="deselectClient">
                        Deseleccionar
                    </flux:button>
                </div>
            </div>
        @elseif($ci && strlen($ci) >= 6)
            <div class="rounded-lg bg-zinc-800 p-4">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-zinc-400">No se encontró ningún cliente con CI: {{ $ci }}</p>
                    <flux:button size="sm" wire:click="openModal">Crear cliente</flux:button>
                </div>
            </div>
        @endif
    </div>

    <flux:modal name="create-client" class="md:w-96" wire:close="createdClient">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Crear cliente</flux:heading>
                <flux:text class="mt-2">Crea un nuevo cliente para la suscripción.</flux:text>
            </div>
            <livewire:client.create from-modal />
        </div>
    </flux:modal>
</div>
