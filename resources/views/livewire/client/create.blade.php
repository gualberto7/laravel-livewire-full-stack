@props(['fromModal' => false])

<div>
    <div class="mb-6">
        <form wire:submit="save" class="space-y-6">

            <div class="grid grid-cols-1 gap-6 {{ $fromModal ? 'md:grid-cols-1' : 'md:grid-cols-2' }}">
                <div class="space-y-2">
                    <flux:label for="name">Nombre completo</flux:label>
                    <flux:input 
                        id="name"
                        wire:model.live="name" 
                        placeholder="Ingrese el nombre completo del cliente" />
                    @error('name') <flux:error>{{ $message }}</flux:error> @enderror
                </div>

                <div class="space-y-2">
                    <flux:label for="ci">Cédula de identidad</flux:label>
                    <flux:input 
                        id="ci"
                        wire:model.live="ci" 
                        placeholder="Ingrese el CI del cliente" />
                    <flux:error name="ci" />
                </div>

                <div class="space-y-2">
                    <flux:label for="phone">Teléfono</flux:label>
                    <flux:input 
                        id="phone"
                        wire:model.live="phone" 
                        placeholder="Ingrese el teléfono del cliente" />
                    <flux:error name="phone" />
                </div>

                <div class="space-y-2">
                    <flux:label for="email">Email (opcional)</flux:label>
                    <flux:input 
                        id="email"
                        type="email"
                        wire:model.live="email" 
                        placeholder="Ingrese el email del cliente" />
                    <flux:error name="email" />
                </div>

                <div class="space-y-2">
                    <flux:label for="avatar">Foto de perfil (opcional)</flux:label>
                    <div class="flex items-center gap-4">
                        <div class="flex-1">
                            <flux:input 
                                id="avatar"
                                type="file"
                                wire:model.live="avatar" 
                                accept="image/*" />
                        </div>
                        @if($avatar)
                            <div class="h-10 w-10 rounded-full overflow-hidden">
                                <img src="{{ $avatar->temporaryUrl() }}" alt="Vista previa" class="h-full w-full object-cover">
                            </div>
                        @endif
                    </div>
                    <flux:error name="avatar" />
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