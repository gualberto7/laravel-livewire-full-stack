<?php 

use App\Models\Client;
use Livewire\Volt\Component;
use App\Traits\VerifiesGymAccess;

new class extends Component {
    use VerifiesGymAccess;

    public Client $client;
    public $subscription;
    public $items = [];

    public function mount(Client $client)
    {
        $this->verifyGymAccess($client);
        $this->client = $client;
        $this->subscription = $client->subscriptions()->with('membership')->where('end_date', '>=', now())->first();
        $this->items = $this->subscription ? $this->setItem($this->subscription) : [];
    }

    public function setItem($subscrtion)
    {
        return [
            [
                'label' => 'Suscripción',
                'value' => $subscrtion->membership->name,
            ],
            [
                'label' => 'Estado',
                'value' => $subscrtion->getStatus(),
            ],
            [
                'label' => 'Fecha de inicio',
                'value' => $subscrtion->start_date->format('d/m/Y'),
            ],
            [
                'label' => 'Fecha de fin',
                'value' => $subscrtion->end_date->format('d/m/Y'),
            ],
            [
                'label' => 'Precio',
                'value' => $subscrtion->membership->price . ' Bs.',
            ],
            [
                'label' => 'Registrado por',
                'value' => $subscrtion->created_by,
            ],
            [
                'label' => 'Registrado el',
                'value' => $subscrtion->created_at->format('d/m/Y H:i'),
            ],
        ];
    }
}

?>

<div>
    @include('partials.client-detail-heading')

    <x-clients.layout :client="$client">
        <x-slot:heading>
            Suscripción actual
        </x-slot>

        <div class="border-gray-200 dark:border-gray-700">
            @if ($items)
                <x-gc.list :items="$items" />
            @else
                <p class="text-gray-500 dark:text-gray-400 mb-4">
                    No hay suscripciones activas.
                </p>
                <flux:button :href="route('subscriptions.create')" variant="primary">
                    Crear suscripción
                </flux:button>
            @endif
        </div>
    </x-clients.layout>
</div>
