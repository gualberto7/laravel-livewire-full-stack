<div>
    <div class="mt-5 md:mt-0 md:col-span-2">
        <form wire:submit.prevent="save">
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <flux:label for="name">Nombre completo</flux:label>
                            <flux:input id="name" wire:model="name" placeholder="Ingrese el nombre completo del cliente" />
                            <flux:error name="name" />
                        </div>

                        <div>
                            <flux:label for="ci">CI *</flux:label>
                            <flux:input id="ci" wire:model="ci" placeholder="Ingrese el CI del cliente" readonly />
                            <flux:error name="ci" />
                        </div>

                        <div>
                            <flux:label for="phone">Teléfono *</flux:label>
                            <flux:input id="phone" wire:model="phone" placeholder="Ingrese el teléfono del cliente" />
                            <flux:error name="phone" />
                        </div>

                        <div>
                            <flux:label for="email">Email</flux:label>
                            <flux:input id="email" wire:model="email" placeholder="Ingrese el email del cliente" />
                            <flux:error name="email" />
                        </div>

                        <div>
                            <flux:label for="avatar">Foto de Perfil</flux:label>
                            <flux:input type="file" wire:model="avatar" id="avatar" placeholder="Ingrese la foto de perfil del cliente" />
                            <flux:error name="avatar" />
                            @if ($avatar)
                                <div class="mt-2">
                                    <img src="{{ Storage::url($avatar) }}" alt="Foto de perfil actual" class="h-20 w-20 rounded-full object-cover">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 text-right sm:px-6">
                    <flux:button type="button" variant="ghost" href="{{ route('clients.index') }}" navigate>
                        Cancelar
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        Guardar
                    </flux:button>
                </div>
            </div>
        </form>
    </div>
</div>