<div class="flex items-start max-md:flex-col">
    <div class="me-10 w-full pb-4 md:w-[220px]">
        <flux:navlist>
            <flux:navlist.item :href="route('clients.show', $client)" wire:navigate>
                {{ __('Detalle') }}
            </flux:navlist.item>
            <flux:navlist.item :href="route('clients.subscriptions', $client)" wire:navigate>
                {{ __('Suscripción actual') }}
            </flux:navlist.item>
            <flux:navlist.item :href="route('clients.check-ins', $client)" wire:navigate>
                {{ __('Check-ins') }}
            </flux:navlist.item>
            <flux:navlist.item :href="route('clients.subscription-history', $client)" wire:navigate>
                {{ __('Historial de suscripciones') }}
            </flux:navlist.item>
        </flux:navlist>
    </div>

    <flux:separator class="md:hidden" />

    <div class="flex-1 self-stretch max-md:pt-6">
        <flux:heading>{{ $heading ?? '' }}</flux:heading>
        <flux:subheading>{{ $subheading ?? '' }}</flux:subheading>

        <div class="mt-5 w-full">
            {{ $slot }}
        </div>
    </div>
</div>