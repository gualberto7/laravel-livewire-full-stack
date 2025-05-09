<div>
    <form wire:submit="save" class="space-y-6">
        <!-- Búsqueda de cliente por CI -->
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

        <!-- Selección de membresía -->
        <div class="space-y-2">
            <flux:label>Membresía</flux:label>
            <flux:select wire:model.live="membership_id">
                <option value="">Seleccione una membresía</option>
                @foreach($memberships as $membership)
                    <option value="{{ $membership->id }}">
                        {{ $membership->name }} - {{ $membership->duration }} días - {{ $membership->price }} Bs.
                    </option>
                @endforeach
            </flux:select>
        </div>

        <!-- Fechas -->
        <div class="grid grid-cols-2 gap-4">
            <div class="space-y-2">
                <flux:label>Fecha de inicio</flux:label>
                <flux:input 
                    type="date" 
                    wire:model.live="start_date" />
            </div>
            <div class="space-y-2">
                <flux:label>Fecha de fin</flux:label>
                <flux:input 
                    type="date" 
                    wire:model="end_date"
                    readonly />
            </div>
        </div>

        <!-- Pago -->
        <flux:heading size="lg">Información de pago</flux:heading>
        <div class="grid grid-cols-2 gap-4">
            <div class="space-y-2">
                <flux:label>Monto</flux:label>
                    <flux:input.group>
                    <flux:input.group.prefix>Bs.</flux:input.group.prefix>
                    <flux:input 
                        type="number" 
                        wire:model="payment_amount"
                        placeholder="Ingrese el monto"
                        readonly />
                </flux:input.group>
            </div>

            <div class="space-y-2">
                <flux:label>Método de pago</flux:label>
                <flux:select wire:model="payment_method">
                    <option value="cash">Efectivo</option>
                    <option value="card">Tarjeta</option>
                    <option value="bank_transfer">Transferencia bancaria</option>
                    <option value="cheque">Cheque</option>
                </flux:select>
            </div>
        </div>

        <!-- Botón de guardar -->
        <div class="flex justify-end">
            <flux:button  type="button" variant="ghost" href="{{ route('subscriptions.index') }}" navigate>Cancelar</flux:button>
            <flux:button variant="primary" type="submit" :disabled="!$selectedClient || !$membership_id">
                Crear suscripción
            </flux:button>
        </div>
    </form>

    <flux:modal name="create-client" class="md:w-96" wire:close="clientCreated">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Crear cliente</flux:heading>
                <flux:text class="mt-2">Crea un nuevo cliente para la suscripción.</flux:text>
            </div>
            <livewire:client.create from-modal />
        </div>
    </flux:modal>
</div>
