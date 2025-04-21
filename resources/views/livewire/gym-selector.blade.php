<div>
    <flux:dropdown position="bottom" align="start">
        <flux:button 
            variant="ghost" 
            icon="building-office-2" 
            icon:trailing="chevron-down"
            class="w-full justify-between"
        >
            {{ $currentGym ? $currentGym->name : 'Seleccionar Gimnasio' }}
        </flux:button>

        <flux:menu>
            @forelse($availableGyms as $gym)
                <flux:menu.item 
                    wire:click="selectGym('{{ $gym->id }}')"
                    :active="$currentGym && $currentGym->id === $gym->id"
                >
                    {{ $gym->name }}
                </flux:menu.item>
            @empty
                <flux:menu.item disabled>
                    No hay gimnasios disponibles
                </flux:menu.item>
            @endforelse
        </flux:menu>
    </flux:dropdown>
</div>
