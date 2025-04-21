<div>
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-white">Crear nuevo cliente</h2>
        <p class="text-zinc-400">Complete los datos del cliente</p>
    </div>

    <form wire:submit="save" class="space-y-6">
        <!-- Nombre -->
        <div class="space-y-2">
            <flux:label for="name">Nombre completo</flux:label>
            <flux:input 
                id="name"
                wire:model.live="name" 
                placeholder="Ingrese el nombre completo del cliente" />
            @error('name') <flux:error>{{ $message }}</flux:error> @enderror
        </div>

        <!-- CI -->
        <div class="space-y-2">
            <flux:label for="ci">Cédula de identidad</flux:label>
            <flux:input 
                id="ci"
                wire:model.live="ci" 
                placeholder="Ingrese el CI del cliente" />
            @error('ci') <flux:error>{{ $message }}</flux:error> @enderror
        </div>

        <!-- Teléfono -->
        <div class="space-y-2">
            <flux:label for="phone">Teléfono</flux:label>
            <flux:input 
                id="phone"
                wire:model.live="phone" 
                placeholder="Ingrese el teléfono del cliente" />
            @error('phone') <flux:error>{{ $message }}</flux:error> @enderror
        </div>

        <!-- Email -->
        <div class="space-y-2">
            <flux:label for="email">Email (opcional)</flux:label>
            <flux:input 
                id="email"
                type="email"
                wire:model.live="email" 
                placeholder="Ingrese el email del cliente" />
            @error('email') <flux:error>{{ $message }}</flux:error> @enderror
        </div>

        <!-- Avatar -->
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
            @error('avatar') <flux:error>{{ $message }}</flux:error> @enderror
        </div>

        <!-- Botones -->
        <div class="flex justify-end gap-3">
            <flux:button type="button" variant="ghost" href="{{ route('clients.index') }}" navigate>
                Cancelar
            </flux:button>
            <flux:button type="submit">
                Crear cliente
            </flux:button>
        </div>
    </form>
</div> 