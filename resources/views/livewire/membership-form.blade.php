<div>
    <form wire:submit="save" class="space-y-6">
        <div class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2">
            <flux:field>
                <flux:label for="name">Nombre</flux:label>
                <flux:input id="name" wire:model="name" type="text" placeholder="Ej: Mensual" />
                @error('name') <flux:error>{{ $message }}</flux:error> @enderror
            </flux:field>

            <flux:field>
                <flux:label for="price">Precio</flux:label>
                <flux:input id="price" wire:model="price" type="text" placeholder="Ej: 100.00" />
                @error('price') <flux:error>{{ $message }}</flux:error> @enderror
            </flux:field>

            <flux:field>
                <flux:label for="duration">Duración (días)</flux:label>
                <flux:input id="duration" wire:model="duration" type="number" min="1" />
                @error('duration') <flux:error>{{ $message }}</flux:error> @enderror
            </flux:field>

            <flux:field>
                <flux:label for="max_entries">Entradas máximas</flux:label>
                <flux:input id="max_entries" wire:model="max_entries" type="number" min="1" placeholder="Opcional" />
                @error('max_entries') <flux:error>{{ $message }}</flux:error> @enderror
            </flux:field>

            <flux:field class="sm:col-span-2">
                <flux:label for="description">Descripción</flux:label>
                <flux:textarea id="description" wire:model="description" rows="3" placeholder="Descripción opcional de la membresía" />
                @error('description') <flux:error>{{ $message }}</flux:error> @enderror
            </flux:field>

            <flux:field variant="inline"  class="sm:col-span-2">
                <flux:checkbox id="is_promo" wire:model.live="is_promo" />
                <flux:label for="is_promo">Es una promoción</flux:label>
            </flux:field>

            @if($is_promo)
                <flux:field>
                    <flux:label for="promo_start_date">Fecha de inicio</flux:label>
                    <flux:input id="promo_start_date" wire:model="promo_start_date" type="date" />
                    @error('promo_start_date') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <flux:field>
                    <flux:label for="promo_end_date">Fecha de fin</flux:label>
                    <flux:input id="promo_end_date" wire:model="promo_end_date" type="date" />
                    @error('promo_end_date') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>
            @endif
        </div>

        <div class="flex justify-end gap-x-3">
            {{-- <flux:button type="button" variant="secondary" wire:click="$dispatch('cancel')">
                Cancelar
            </flux:button> --}}
            <flux:button type="submit">
                Crear membresía
            </flux:button>
        </div>
    </form>
</div> 