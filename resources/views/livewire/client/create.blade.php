@props(['fromModal' => false])

<div>
    <div class="mb-6">
        <form wire:submit="save" class="space-y-6">

            <div class="grid grid-cols-1 gap-6 {{ $fromModal ? 'md:grid-cols-1' : 'md:grid-cols-2' }}">
                <div class="space-y-2">
                    <flux:label for="name">Nombre completo</flux:label>
                    <flux:input 
                        id="name"
                        wire:model.blur="name" 
                        placeholder="Ingrese el nombre completo del cliente" />
                    <flux:error name="name" />
                </div>

                <div class="space-y-2">
                    <flux:label for="ci">Carnet de identidad</flux:label>
                    <flux:input 
                        id="ci"
                        wire:model.blur="ci" 
                        placeholder="Ingrese el CI del cliente" />
                    <flux:error name="ci" />
                </div>

                <div class="space-y-2">
                    <flux:label for="phone">Celular</flux:label>
                    <flux:input 
                        id="phone"
                        wire:model.blur="phone" 
                        placeholder="Ingrese el celular del cliente" />
                    <flux:error name="phone" />
                </div>

                <div class="space-y-2">
                    <flux:label for="email">Correo electrónico (opcional)</flux:label>
                    <flux:input 
                        id="email"
                        type="email"
                        wire:model.blur="email" 
                        placeholder="Ingrese el email del cliente" />
                    <flux:error name="email" />
                </div>
            </div>

            <div class="flex justify-end gap-3">
                @if(!$fromModal)
                    <flux:button type="button" variant="ghost" href="{{ route('clients.index') }}" navigate>
                        Cancelar
                    </flux:button>
                @endif
                <flux:button type="submit" variant="primary">
                    Crear cliente
                </flux:button>
            </div>
        </form>
    </div>
</div> 