<div>
    <form wire:submit="save" class="space-y-6">
        <div class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2">
            <flux:field>
                <flux:label for="name">Nombre</flux:label>
                <flux:input id="name" wire:model="form.name" type="text" placeholder="Ej: Mensual" />
                <flux:error name="form.name" />
            </flux:field>

            <flux:field>
                <flux:label for="price">Precio</flux:label>
                <flux:input id="price" wire:model="form.price" type="text" placeholder="Ej: 100.00" />
                <flux:error name="form.price" />
            </flux:field>

            <flux:field>
                <flux:label for="duration">Duración (días)</flux:label>
                <flux:input id="duration" wire:model="form.duration" type="number" min="1" />
                <flux:error name="form.duration" />
            </flux:field>

            <flux:field>
                <flux:label for="max_checkins">Entradas máximas</flux:label>
                <flux:input id="max_checkins" wire:model="form.max_checkins" type="number" min="1" placeholder="Opcional" />
                <flux:error name="form.max_checkins" />
            </flux:field>

            <flux:field class="sm:col-span-2">
                <flux:label for="description">Descripción</flux:label>
                <flux:textarea id="description" wire:model="form.description" rows="3" placeholder="Descripción opcional de la membresía" />
                <flux:error name="form.description" />
            </flux:field>

            <flux:field variant="inline"  class="sm:col-span-2">
                <flux:checkbox id="is_promo" wire:model.live="form.is_promo" />
                <flux:label for="is_promo">Es una promoción</flux:label>
            </flux:field>

            @if($form->is_promo)
                <flux:field>
                    <flux:label for="promo_start_date">Fecha de inicio</flux:label>
                    <flux:input id="promo_start_date" wire:model="form.promo_start_date" type="date" />
                    <flux:error name="form.promo_start_date" />
                </flux:field>

                <flux:field>
                    <flux:label for="promo_end_date">Fecha de fin</flux:label>
                    <flux:input id="promo_end_date" wire:model="form.promo_end_date" type="date" />
                    <flux:error name="form.promo_end_date" />
                </flux:field>
            @endif
        </div>

        <div class="flex justify-end gap-x-3">
            <flux:button type="button" variant="ghost" href="{{ route('memberships.index') }}" navigate>
                Cancelar
            </flux:button>
            <flux:button type="submit">
                Actualizar membresía
            </flux:button>
        </div>
    </form>
</div> 