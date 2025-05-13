<div>
    <form wire:submit="save" class="space-y-6">

        {{-- <div class="mb-4">
            <livewire:client.find />
        </div> --}}

        <div class="mb-4">
            <flux:label>Membresía</flux:label>
            <flux:select wire:model.live="form.membership_id">
                <option value="">Seleccione una membresía</option>
                @foreach($memberships as $membership)
                    <option value="{{ $membership->id }}">
                        {{ $membership->name }} - {{ $membership->duration }} días - {{ $membership->price }} Bs.
                    </option>
                @endforeach
            </flux:select>
            <flux:error name="form.membership_id" />
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <flux:label>Fecha de inicio</flux:label>
                <flux:input 
                    type="date" 
                    wire:model="form.start_date" />
                <flux:error name="form.start_date" />
            </div>
            <div>
                <flux:label>Fecha de fin</flux:label>
                <flux:input 
                    type="date" 
                    wire:model="form.end_date"
                    readonly />
                <flux:error name="form.end_date" />
            </div>
        </div>

        {{-- <flux:heading size="lg" class="mb-2">Información de pago</flux:heading>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <flux:label>Monto</flux:label>
                    <flux:input.group>
                    <flux:input.group.prefix>Bs.</flux:input.group.prefix>
                    <flux:input 
                        type="number" 
                        wire:model="form.payment_amount"
                        placeholder="Ingrese el monto"
                        readonly />
                    <flux:error name="form.payment_amount" />
                </flux:input.group>
            </div>

            <div>
                <flux:label>Método de pago</flux:label>
                <flux:select wire:model="form.payment_method">
                    <option value="cash">Efectivo</option>
                    <option value="card">Tarjeta</option>
                    <option value="bank_transfer">Transferencia bancaria</option>
                    <option value="cheque">Cheque</option>
                </flux:select>
                <flux:error name="form.payment_method" />
            </div>
        </div> --}}

        <div class="flex justify-end">
            <flux:button type="button" variant="ghost" href="{{ route('subscriptions.index') }}" navigate>Cancelar</flux:button>
            <flux:button type="submit" variant="primary">
                Crear suscripción
            </flux:button>
        </div>
    </form>
</div>
