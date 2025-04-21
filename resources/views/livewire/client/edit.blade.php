<div>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Editar Cliente</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Actualiza la información del cliente. Todos los campos marcados con * son obligatorios.
                    </p>
                </div>
            </div>

            <div class="mt-5 md:mt-0 md:col-span-2">
                <form wire:submit.prevent="save">
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-4">
                                    <flux:label for="name">Nombre completo</flux:label>
                                    <flux:input id="name" wire:model="name" placeholder="Ingrese el nombre completo del cliente" />
                                    <flux:error name="name" />
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <flux:label for="ci">CI *</flux:label>
                                    <flux:input id="ci" wire:model="ci" placeholder="Ingrese el CI del cliente" />
                                    <flux:error name="ci" />
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <flux:label for="phone">Teléfono *</flux:label>
                                    <flux:input id="phone" wire:model="phone" placeholder="Ingrese el teléfono del cliente" />
                                    <flux:error name="phone" />
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <flux:label for="email">Email</flux:label>
                                    <flux:input id="email" wire:model="email" placeholder="Ingrese el email del cliente" />
                                    <flux:error name="email" />
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <flux:label for="profile_photo">Foto de Perfil</flux:label>
                                    <flux:input type="file" wire:model="profile_photo" id="profile_photo" placeholder="Ingrese la foto de perfil del cliente" />
                                    <flux:error name="profile_photo" />
                                    @if ($profile_photo_path)
                                        <div class="mt-2">
                                            <img src="{{ Storage::url($profile_photo_path) }}" alt="Foto de perfil actual" class="h-20 w-20 rounded-full object-cover">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 text-right sm:px-6">
                            <flux:button type="button" variant="ghost" href="{{ route('clients.index') }}" navigate>
                                Cancelar
                            </flux:button>
                            <flux:button type="submit">
                                Guardar
                            </flux:button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> 